const ctx = document.getElementById('chartVendasDepartamento');

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Com 1', 'Com 2'],
                                datasets: [{
                                    label: 'Valor Vendido R$',
                                    data: [<?php echo $totalSomaVendasComercial1; ?>, <?php echo $totalSomaVendasComercial2; ?>],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(255, 159, 64)',
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                scales: {
                                    y: {

                                        grid: {
                                            display: false,
                                        },
                                    },
                                    x: {
                                        display: false, // Remove o eixo X
                                    },
                                },
                                plugins: {
                                    legend: {
                                        display: false, // Desabilita a legenda
                                    },
                                },
                            }
                        });