const navigate = (step) => {
    const url = new URL(window.location.href);
    const year = parseInt(url.searchParams.get('year') || new Date().getFullYear());
    const month = parseInt(url.searchParams.get('month') || new Date().getMonth() + 1);

    let newMonth = month + step;
    let newYear = year;

    if (newMonth > 12) {
        newYear++;
        newMonth = 1;
    } else if (newMonth < 1) {
        newYear--;
        newMonth = 12;
    }

    url.searchParams.set('year', newYear);
    url.searchParams.set('month', newMonth);
    window.location.href = url.toString();
};

const searchCalendar = () => {
    const year = document.getElementById('yearInput').value;
    const month = document.getElementById('monthInput').value;

    if (year && month) {
        const url = new URL(window.location.href);
        url.searchParams.set('year', year);
        url.searchParams.set('month', month);
        window.location.href = url.toString();
    }
};

const updateRange = (value) => {
    document.getElementById('rangeValue').innerText = value;
    const url = new URL(window.location.href);
    url.searchParams.set('year', value);
    window.location.href = url.toString();
};

// 氣象API
fetch(`https://api.open-meteo.com/v1/forecast?latitude=25.033&longitude=121.5654&current_weather=true`)
    .then(response => response.json())
    .then(data => {
        const weather = data.current_weather;
        const icon = weather.weathercode;
        document.getElementById('weatherIcon').textContent = icon === 0 ? '☀️' : '🌥️';
        document.getElementById('weatherText').textContent = `${weather.temperature}°C`;
    });
