// Update price display when class is changed
document.querySelectorAll('[id^="class-selector-"]').forEach((select) => {
    select.addEventListener("change", function () {
        const flightId = this.id.split("-").pop();
        const price = this.options[this.selectedIndex].dataset.price;
        const formattedPrice = new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        })
            .format(price)
            .replace("IDR", "Rp ");

        document.getElementById(`price-display-${flightId}`).textContent =
            formattedPrice;
    });
});

// Price range slider
const priceRange = document.getElementById("priceRange");
const priceRangeValue = document.getElementById("priceRangeValue");

if (priceRange && priceRangeValue) {
    priceRange.addEventListener("input", function () {
        const formattedPrice = new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        })
            .format(this.value)
            .replace("IDR", "Rp ");

        priceRangeValue.textContent = formattedPrice;
    });
}

// Filter airlines by search
const airlineSearch = document.getElementById("airlineSearch");
const airlineItems = document.querySelectorAll(".airline-item");

if (airlineSearch) {
    airlineSearch.addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase();

        airlineItems.forEach((item) => {
            const airlineName = item
                .querySelector(".airline-name")
                .textContent.toLowerCase();
            if (airlineName.includes(searchTerm)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });
}

document.querySelectorAll(".class-selector").forEach((select) => {
    select.addEventListener("change", function () {
        const flightId = this.id.replace("class-selector-", ""); // Ambil ID penerbangan
        const selectedClassId = this.value;
        const price = this.options[this.selectedIndex].dataset.price;

        // Format harga dalam Rupiah
        const formattedPrice = new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        })
            .format(price)
            .replace("IDR", "Rp ");

        // Update harga di elemen yang sesuai
        const priceElement = document.getElementById(
            `price-display-${flightId}`
        );
        if (priceElement) {
            priceElement.textContent = formattedPrice;
        }

        // Fetch fasilitas berdasarkan kelas penerbangan
        fetch(`/get-facilities/${selectedClassId}`)
            .then((response) => response.json())
            .then((data) => {
                const facilitiesContainer = document.getElementById(
                    `facilities-${flightId}`
                );

                if (facilitiesContainer) {
                    facilitiesContainer.innerHTML = ""; // Kosongkan sebelum menambahkan baru

                    if (data.length > 0) {
                        data.forEach((facility) => {
                            const facilityItem = document.createElement("div");
                            facilityItem.classList.add("facility-item");
                            facilityItem.innerHTML = `
                                    <i class="bi ${
                                        facility.icon_class || "bi-check-circle"
                                    } text-primary"></i>
                                    <span class="small">${facility.name}</span>
                                `;
                            facilitiesContainer.appendChild(facilityItem);
                        });
                    } else {
                        facilitiesContainer.innerHTML =
                            '<span class="small text-muted">No facilities available</span>';
                    }
                }
            })
            .catch((error) =>
                console.error("Error fetching facilities:", error)
            );
    });
});

// Reset filters function
function resetFilters() {
    document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
        checkbox.checked = false;
    });

    if (priceRange) {
        priceRange.value = 5000000;
        priceRangeValue.textContent = "Rp 5.000.000";
    }

    document.getElementById("filter-form").submit();
}
