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

    document.getElementById("priceRange").value = 1000;
}
