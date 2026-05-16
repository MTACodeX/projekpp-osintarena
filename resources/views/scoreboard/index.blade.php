@extends('layouts.app')

@section('content')
<div class="scoreboard-header">
    <div>
        <h1>Scoreboard</h1>
        <p>Peringkat akan diperbarui otomatis ketika ada peserta yang solve.</p>
    </div>

    <div class="scoreboard-status">
        <span class="live-dot"></span>
        <span>LIVE</span>
        <small id="lastUpdate">Loading...</small>
    </div>
</div>

<div id="podiumSection" class="podium-section">
    <div class="podium-grid" id="podiumGrid">
        <div class="podium-empty">Loading top 3...</div>
    </div>
</div>

<div class="scoreboard-table-section">
    <h2>Ranking Lainnya</h2>

    <div class="scoreboard-wrapper">
        <table class="table scoreboard-table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Team Name</th>
                    <th>Score</th>
                    <th>Solves</th>
                    <th>Last Solve</th>
                </tr>
            </thead>

            <tbody id="scoreboardBody">
                <tr>
                    <td colspan="5">Loading scoreboard...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    let lastScoreboardJson = '';

    async function loadScoreboard() {
        try {
            const response = await fetch('/scoreboard/data', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data scoreboard');
            }

            const data = await response.json();
            const currentJson = JSON.stringify(data.teams);

            document.getElementById('lastUpdate').textContent = 'Update: ' + data.updated_at;

            if (currentJson === lastScoreboardJson) {
                return;
            }

            lastScoreboardJson = currentJson;

            renderPodium(data.teams);
            renderTable(data.teams);
        } catch (error) {
            document.getElementById('lastUpdate').textContent = 'Gagal update';
            console.error(error);
        }
    }

    function renderPodium(teams) {
        const podiumGrid = document.getElementById('podiumGrid');
        podiumGrid.innerHTML = '';

        const first = teams.find(team => team.rank === 1);
        const second = teams.find(team => team.rank === 2);
        const third = teams.find(team => team.rank === 3);

        const displayOrder = [second, first, third];

        const hasTopThree = displayOrder.some(team => team);

        if (!hasTopThree) {
            podiumGrid.innerHTML = '<div class="podium-empty">Belum ada data top 3.</div>';
            return;
        }

        displayOrder.forEach((team, index) => {
            if (!team) {
                const emptyCard = document.createElement('div');
                emptyCard.className = 'podium-card podium-empty-card';
                emptyCard.innerHTML = `
                    <div class="podium-rank-badge">-</div>
                    <div class="podium-icon-circle">•</div>
                    <h3>Belum ada tim</h3>
                    <p>0 pts</p>
                `;
                podiumGrid.appendChild(emptyCard);
                return;
            }

            let rankClass = '';
            let icon = '🏅';

            if (team.rank === 1) {
                rankClass = 'podium-first';
                icon = '👑';
            } else if (team.rank === 2) {
                rankClass = 'podium-second';
                icon = '🥈';
            } else if (team.rank === 3) {
                rankClass = 'podium-third';
                icon = '🥉';
            }

            const card = document.createElement('div');
            card.className = `podium-card ${rankClass} flash-row`;

            card.innerHTML = `
                <div class="podium-rank-badge">${team.rank}</div>
                <div class="podium-icon-circle">${icon}</div>
                <h3>${escapeHtml(team.team_name)}</h3>
                <div class="podium-score">${team.score} pts</div>
                <div class="podium-meta">
                    <small>Solves: ${team.solves}</small>
                    <small>${team.last_solve}</small>
                </div>
            `;

            podiumGrid.appendChild(card);

            setTimeout(() => {
                card.classList.remove('flash-row');
            }, 900);
        });
    }

    function renderTable(teams) {
        const tbody = document.getElementById('scoreboardBody');
        tbody.innerHTML = '';

        const remainingTeams = teams.filter(team => team.rank >= 4);

        if (remainingTeams.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5">Belum ada tim selain top 3.</td>
                </tr>
            `;
            return;
        }

        remainingTeams.forEach((team) => {
            const row = document.createElement('tr');
            row.className = 'scoreboard-row flash-row';

            row.innerHTML = `
                <td>#${team.rank}</td>
                <td><strong>${escapeHtml(team.team_name)}</strong></td>
                <td>${team.score}</td>
                <td>${team.solves}</td>
                <td>${team.last_solve}</td>
            `;

            tbody.appendChild(row);

            setTimeout(() => {
                row.classList.remove('flash-row');
            }, 900);
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    loadScoreboard();
    setInterval(loadScoreboard, 10000);
</script>
@endsection