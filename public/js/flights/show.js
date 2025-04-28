document.addEventListener("DOMContentLoaded", function () {
    // Elements
    const classRadios = document.querySelectorAll(".class-radio");
    const passengerCount = document.getElementById("passengerCount");
    const passengerCountDisplay = document.getElementById(
        "passengerCountDisplay"
    );
    const basePrice = document.getElementById("basePrice");
    const totalPrice = document.getElementById("totalPrice");
    const promoCode = document.getElementById("promoCode");
    const promoRow = document.querySelector(".promo-row");
    const promoDiscount = document.getElementById("promoDiscount");
    const facilityContainer = document.querySelector(".facility-container"); // Container fasilitas

    // Update tampilan kelas yang dipilih
    classRadios.forEach((radio) => {
        radio.addEventListener("change", function () {
            document
                .querySelectorAll(".class-tab")
                .forEach((tab) => tab.classList.remove("active"));
            this.closest(".form-check")
                .querySelector(".class-tab")
                .classList.add("active");

            updateFacilities(this);
            updatePrices();
        });
    });

    // Update jumlah penumpang
    if (passengerCount) {
        passengerCount.addEventListener("change", function () {
            passengerCountDisplay.textContent = this.value;
            updatePrices();
        });
    }

    // Update kode promo
    if (promoCode) {
        promoCode.addEventListener("change", function () {
            promoRow.style.display = this.value ? "flex" : "none";
            updatePrices();
        });
    }

    // Update harga berdasarkan kelas dan jumlah penumpang
    function updatePrices() {
        const selectedClass = document.querySelector(".class-radio:checked");
        if (!selectedClass) return;

        const price = parseInt(selectedClass.dataset.price);
        const passengers = parseInt(passengerCount.value);

        basePrice.textContent = "Rp " + price.toLocaleString("id-ID");
        let subtotal = price * passengers;

        let discount = 0;
        if (promoCode && promoCode.value) {
            const selectedOption = promoCode.options[promoCode.selectedIndex];
            const discountAmount = parseInt(selectedOption.dataset.discount);
            const discountType = selectedOption.dataset.type;

            if (discountType === "percentage") {
                discount = Math.round((subtotal * discountAmount) / 100);
            } else {
                discount = discountAmount;
            }

            promoDiscount.textContent =
                "- Rp " + discount.toLocaleString("id-ID");
        }

        totalPrice.textContent =
            "Rp " + (subtotal - discount).toLocaleString("id-ID");
    }

    // Update fasilitas berdasarkan kelas
    function updateFacilities(selectedRadio) {
        if (!facilityContainer) return;
        facilityContainer.innerHTML = "";

        const facilities =
            JSON.parse(selectedRadio.getAttribute("data-facilities")) || [];
        if (facilities.length === 0) {
            facilityContainer.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i> No facilities available for this class.
                        </div>
                    </div>
                `;
            return;
        }
        facilities.forEach((facility) => {
            const facilityElement = document.createElement("div");
            facilityElement.classList.add("col-md-3", "col-6", "mb-4"); // Added margin for spacing
            facilityElement.innerHTML = `
        <div class="facility-card bg-white shadow-sm rounded p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
            <img src="/storage/${facility.image}" alt="${facility.name}" class="img-fluid mb-3" style="max-height: 60px; object-fit: contain;">
            <p class="mb-0 font-weight-bold text-dark">${facility.name}</p>
        </div>
    `;
            facilityContainer.appendChild(facilityElement);
        });
    }

    // Inisialisasi tampilan harga dan fasilitas awal
    updatePrices();
    const selectedClass = document.querySelector(".class-radio:checked");
    if (selectedClass) {
        updateFacilities(selectedClass);
    }
});
