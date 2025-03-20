<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo Cáo Thống Kê</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Tổng quát */
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
        color: #333;
    }

    /* Container */
    .container {
        display: flex;
        height: 100vh;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #202c46; /* Primary dark navy */
        border-bottom: 1px solid #151d30;
        height: 60px;
        color: #fff;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo img.avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .logo span {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
    }

    .menu {
        width: 100%;
        text-align: right;
    }

    .menu a {
        margin-left: 20px;
        text-decoration: none;
        color: #c3cad9;
        font-size: 14px;
        transition: color 0.3s;
    }

    .menu a:hover {
        color: #fff;
    }

    nav {
        display: block;
        unicode-bidi: isolate;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #293654; /* Slightly lighter navy for sidebar */
        border-right: 1px solid #202c46;
        padding: 20px 10px;
        text-align: left;
        color: #fff;
    }

    .sidebar .logo {
        text-align: center;
    }

    .sidebar .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 10px;
        border: 3px solid #3d4a68;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        margin-top: 20px;
    }

    .sidebar ul li {
        padding: 12px 15px;
        border-bottom: 1px solid #34405e;
    }

    .sidebar ul li a {
        text-decoration: none;
        color: #e0edff;
        display: block;
        transition: color 0.3s;
    }

    .sidebar ul li a:hover {
        color: #fff;
        background-color: #17213a; /* Darker navy for hover */
        border-radius: 4px;
        padding: 8px;
        margin: -8px;
    }

    /* Main Content */
    .main-content {
        flex-grow: 1;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .topbar {
        display: flex;
        justify-content: flex-end;
        border-bottom: 1px solid #d1dbe8;
        padding: 10px 0;
    }

    .topbar-links a {
        margin-left: 15px;
        text-decoration: none;
        color: #202c46;
    }

    .topbar-links a:hover {
        text-decoration: underline;
    }

    /* Content Section */
    .stats {
        margin-top: 20px;
    }

    .stats h2 {
        margin-bottom: 20px;
        color: #202c46;
    }

    .stats-cards {
        display: flex;
        gap: 20px;
    }

    .card {
        flex: 1;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #d1dbe8;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(32, 44, 70, 0.1);
    }

    .card p {
        font-size: 16px;
        margin: 10px 0;
        color: #3d4a68;
    }

    .card .value {
        font-size: 26px;
        font-weight: bold;
        color: #202c46;
    }

    .card .icon {
        font-size: 24px;
        color: #34405e;
    }

    /* Stats Table */
    .product-stats {
        margin-top: 40px;
    }

    .stats-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 2px 10px rgba(32, 44, 70, 0.1);
    }

    .stats-table th,
    .stats-table td {
        border: 1px solid #d1dbe8;
        padding: 12px 15px;
        text-align: center;
    }

    .stats-table th {
        background-color: #202c46;
        color: #fff;
        font-weight: 600;
    }

    .stats-table tr:nth-child(odd) {
        background-color: #f5f8fc;
    }

    .stats-table tr:hover {
        background-color: #e6edf5;
    }

    /* Chart Container */
    .chart-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #d1dbe8;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(32, 44, 70, 0.1);
    }

    .chart-options {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .chart-options button {
        padding: 10px 15px;
        background-color: #202c46; /* Dark navy buttons */
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .chart-options button:hover {
        background-color: #17213a; /* Darker navy for hover */
    }

    h2 {
        color: #202c46; /* Dark navy heading */
        margin-bottom: 25px;
        border-bottom: 2px solid #d1dbe8;
        padding-bottom: 10px;
    }
</style>
<body>
<header class="header">
    <div class="logo">
        <img class="avatar" src="/view/assets/images/logo.png" alt="Logo">
        <span>Quản Trị Hệ Thống</span>
    </div>
    <div class="menu">
        <a href="/admin/dashboard">Trang Chủ</a>
        <a href="/admin/profile">Tài Khoản</a>
        <a href="/logout">Đăng Xuất</a>
    </div>
</header>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img class="avatar" src="/view/assets/images/admin-avatar.jpg" alt="Admin Avatar">
            <p>Xin chào, Admin</p>
        </div>
        <ul>
            <li><a href="/admin/dashboard">Bảng Điều Khiển</a></li>
            <li><a href="/admin/products">Quản Lý Sản Phẩm</a></li>
            <li><a href="/admin/categories">Quản Lý Danh Mục</a></li>
            <li><a href="/admin/orders">Quản Lý Đơn Hàng</a></li>
            <li><a href="/admin/customers">Quản Lý Khách Hàng</a></li>
            <li><a href="/admin/reports">Báo Cáo Thống Kê</a></li>
            <li><a href="/admin/settings">Cài Đặt Hệ Thống</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Trang Báo Cáo Doanh Thu</h2>

        <div class="chart-container" style="width: 100%; height: 500px;">
            <canvas id="revenueChart"></canvas>
        </div>

        <div class="chart-options">
            <button onclick="showChart('daily')">Doanh Thu Theo Ngày</button>
            <button onclick="showChart('monthly')">Doanh Thu Theo Tháng</button>
            <button onclick="showChart('yearly')">Doanh Thu Theo Năm</button>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let chartInstance = null;
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1;
    const months = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];

    // Function to show the chart
    function showChart(period) {
        // Clear previous chart
        if (chartInstance) {
            chartInstance.destroy();
        }

        let url = '';
        let labels = [];
        let data = [];

        // Set API URL based on the period
        switch (period) {
            case 'daily':
                url = '/food_web/admin/revenue/daily/current-month'; // API for daily revenue
                break;
            case 'monthly':
                url = '/food_web/admin/revenue/month/current-year'; // API for monthly revenue
                break;
            case 'yearly':
                url = '/food_web/admin/revenue/fiveYear'; // API for 5 years revenue
                break;
        }

        // AJAX call to fetch data
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                // The response should contain the revenue data
                if (period === 'daily') {
                    labels = getDaysInMonth(currentYear, currentMonth);
                    data = response;
                } else if (period === 'monthly') {
                    labels = months;
                    data = response;
                } else if (period === 'yearly') {
                    labels = [currentYear - 4, currentYear - 3, currentYear - 2, currentYear - 1, currentYear];
                    data = response;
                }

                // Format the data to avoid scientific notation
                data = formatRevenueData(data);
                console.log(data)

                // Create the new chart
                const chartConfig = {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Doanh Thu',
                            data: data,
                            borderColor: '#1a62cf',
                            backgroundColor: 'rgba(45, 115, 219, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                enabled: true,
                                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                titleColor: '#1a62cf',
                                bodyColor: '#2d73db',
                                borderColor: '#d3e2ff',
                                borderWidth: 1,
                                boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(45, 115, 219, 0.1)'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(45, 115, 219, 0.1)'
                                }
                            }
                        }
                    }
                };

                chartInstance = new Chart(ctx, chartConfig);
            },
            error: function(error) {
                console.error("Error fetching revenue data:", error);
            }
        });
    }

    // Function to get the days in a given month
    function getDaysInMonth(year, month) {
        const days = [];
        const date = new Date(year, month - 1, 2); // Start at the first day of the month
        const lastDateOfMonth = new Date(year, month, 1); // Get the last day of the month

        // Loop through the days of the month
        while (date <= lastDateOfMonth) {
            days.push(new Date(date).toISOString().split('T')[0]); // Format each date as YYYY-MM-DD
            date.setDate(date.getDate() + 1); // Move to the next day
        }

        return days;
    }

    // Format revenue data to avoid scientific notation
    function formatRevenueData(data) {
        return data.map(item => {
            return parseFloat(item).toFixed(2);  // Adjust the number of decimal places as needed
        });
    }

    // Load the default chart (daily)
    window.onload = function () {
        showChart('daily'); // Default to daily chart
    };
</script>
</body>
</html>