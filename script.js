function showDashboard(dashboardId) {
    const dashboards = document.querySelectorAll('.dashboard');
    dashboards.forEach(dashboard => {
        dashboard.classList.add('hidden');
    });

    const selectedDashboard = document.getElementById(dashboardId);
    if (selectedDashboard) {
        selectedDashboard.classList.remove('hidden');
    }
}

// Show Waste Owner Dashboard by default
window.onload = function() {
    showDashboard('waste_owner');
};