document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.contest-card').forEach((card) => {
        const startTime = new Date(card.getAttribute('data-start'));
        const endTime = new Date(card.getAttribute('data-end'));

        const timerEl = card.querySelector('.countdown-timer');
        const progressBar = card.querySelector('.progress-fill');
        const daysEl = timerEl.querySelector('.days');
        const hoursEl = timerEl.querySelector('.hours');
        const minutesEl = timerEl.querySelector('.minutes');
        const secondsEl = timerEl.querySelector('.seconds');

        let statusLabel = card.querySelector('.status-label');

        function update() {
            const now = new Date();

            // Remove previous classes
            statusLabel.classList.remove('bg-secondary', 'bg-warning', 'bg-success', 'bg-dark');

            if (now < startTime) {
                statusLabel.textContent = "Starting Soon";
                statusLabel.classList.add('bg-warning');
                const remaining = startTime - now;
                updateCountdown(remaining);
                progressBar.style.width = `0%`;
            } else if (now >= startTime && now < endTime) {
                statusLabel.textContent = "Running";
                statusLabel.classList.add('bg-success');
                const total = endTime - startTime;
                const elapsed = now - startTime;
                const remaining = endTime - now;
                const progressPercent = Math.min((elapsed / total) * 100, 100);
                progressBar.style.width = `${progressPercent.toFixed(1)}%`;
                updateCountdown(remaining);
            } else {
                statusLabel.textContent = "Ended";
                statusLabel.classList.add('bg-dark');
                updateCountdown(0);
                progressBar.style.width = `100%`;
            }
        }

        function updateCountdown(remaining) {
            if (remaining <= 0) {
                daysEl.textContent = '00';
                hoursEl.textContent = '00';
                minutesEl.textContent = '00';
                secondsEl.textContent = '00';
                return;
            }

            const secs = Math.floor((remaining / 1000) % 60);
            const mins = Math.floor((remaining / 1000 / 60) % 60);
            const hrs = Math.floor((remaining / (1000 * 60 * 60)) % 24);
            const days = Math.floor(remaining / (1000 * 60 * 60 * 24));

            daysEl.textContent = String(days).padStart(2, '0');
            hoursEl.textContent = String(hrs).padStart(2, '0');
            minutesEl.textContent = String(mins).padStart(2, '0');
            secondsEl.textContent = String(secs).padStart(2, '0');
        }

        update();
        setInterval(update, 1000);
    });

})