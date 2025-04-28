async function fetchWeather(city) {
    const url = `https://wttr.in/${city}?format=%t+%C+in+%l`;

    try {
        const response = await fetch(url);
        const data = await response.text();
        document.getElementById(
            "weather"
        ).innerHTML = `<i class="fas fa-cloud-sun"></i> ${data}`;
    } catch (error) {
        document.getElementById("weather").innerHTML =
            "Weather data unavailable";
    }
}

function updateLocalTime(timezone) {
    function formatTime() {
        const now = new Date();
        const options = {
            timeZone: timezone,
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
            hour12: false,
        };
        document.getElementById("localTime").innerHTML =
            new Intl.DateTimeFormat("id-ID", options).format(now);
    }
    formatTime();
    setInterval(formatTime, 1000);
}

async function getLocationAndWeather() {
    if (!navigator.geolocation) {
        document.getElementById("weather").innerHTML =
            "Geolocation not supported";
        return;
    }

    navigator.geolocation.getCurrentPosition(
        async (position) => {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            try {
                // Ambil lokasi dari koordinat GPS
                const geoResponse = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`
                );
                const geoData = await geoResponse.json();
                const city =
                    geoData.address.city ||
                    geoData.address.town ||
                    geoData.address.village ||
                    "Jakarta";

                // Ambil zona waktu otomatis berdasarkan browser
                const timezone =
                    Intl.DateTimeFormat().resolvedOptions().timeZone;

                fetchWeather(city);
                updateLocalTime(timezone);
            } catch (error) {
                document.getElementById("weather").innerHTML =
                    "Error fetching location";
                document.getElementById("localTime").innerHTML =
                    "Time unavailable";
            }
        },
        () => {
            // Jika user menolak lokasi, default ke Jakarta
            document.getElementById("weather").innerHTML =
                "Using default location: Jakarta";
            fetchWeather("Jakarta");
            updateLocalTime("Asia/Jakarta");
        }
    );
}

document.addEventListener("DOMContentLoaded", getLocationAndWeather);
