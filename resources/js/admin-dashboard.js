document.addEventListener('DOMContentLoaded', function () {

    const months = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul'
    ];

    const vals = [
        28,
        35,
        22,
        42,
        38,
        48,
        44
    ];

    const container = document.getElementById('barChart');
    const labelContainer = document.getElementById('barLabels');

    if (!container || !labelContainer) {
        return;
    }

    const max = Math.max(...vals);

    vals.forEach((value, index) => {

        const group = document.createElement('div');
        group.className = 'bar-group';

        const bar = document.createElement('div');
        bar.className = 'bar';

        bar.style.height = (value / max * 100) + '%';

        bar.style.background =
            index === 5
                ? 'var(--orange-500)'
                : 'var(--green-400)';

        bar.title = `Rp ${value}jt`;

        group.appendChild(bar);

        container.appendChild(group);

        const label = document.createElement('div');

        label.style.cssText =
            'flex:1;text-align:center;font-size:10px;color:var(--text-muted);margin-top:4px';

        label.textContent = months[index];

        labelContainer.appendChild(label);

    });

});