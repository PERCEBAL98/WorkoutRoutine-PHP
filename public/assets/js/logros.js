$(document).ready(function () {
    $.ajax({
        url: `${BASE_URL}/obtenerLogros`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let nombre in data) {
                const logros = data[nombre];
                logros.forEach(logro => {
                    const canvasId = `${nombre.toLowerCase().replace(/\s/g, '_')}_nivel_${logro.nivel_logro}`;
                    const porcentaje = (parseInt(logro.puntos_actuales) / parseInt(logro.puntos_maximos)) * 100;
                    const canvas = document.getElementById(canvasId);

                    if (canvas) {
                        new Chart(canvas, {
                            type: 'doughnut',
                            data: {
                                datasets: [{
                                    data: [porcentaje, 100 - porcentaje],
                                    backgroundColor: ['#73D0B9', '#dce2e8'],
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                cutout: '80%',
                                plugins: {
                                    tooltip: { enabled: false },
                                    legend: { display: false },
                                    porcentajeCentral: {
                                        text: `${Math.round(porcentaje)}%`
                                    }
                                }
                            },
                            plugins: [{
                                id: 'porcentajeCentral',
                                beforeDraw(chart) {
                                    const { width, height } = chart;
                                    const ctx = chart.ctx;
                                    ctx.restore();

                                    const fontSize = (height / 15).toFixed(2);
                                    ctx.font = `${fontSize}px Outfit`;
                                    ctx.textBaseline = 'middle';
                                    ctx.fillStyle = '#3C3C43';

                                    const text = chart.config.options.plugins.porcentajeCentral.text;
                                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                                    const textY = height / 2;

                                    ctx.fillText(text, textX, textY);
                                    ctx.save();
                                }
                            }]
                        });
                    }
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error cargando detalles de la rutina:", error);
        }
    });
});
