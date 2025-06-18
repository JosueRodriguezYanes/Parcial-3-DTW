<!DOCTYPE html>
<html>
<head>
    <title>Web Workers - Números primos</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Calculadora de Números Primos con Web Worker</h2>
    <input type="number" id="limite" placeholder="Ingresa un número límite" />
    <button onclick="iniciarWorker()">Calcular</button>

    <div id="resultado"></div>

    <script>
        let worker;

        function iniciarWorker() {
            const limite = document.getElementById('limite').value;
            const resultado = document.getElementById('resultado');
            resultado.innerHTML = "Calculando...";

            try {
                if (typeof(Worker) !== "undefined") {
                    if (!worker) {
                        worker = new Worker("/JS/worker.js");
                    }

                    worker.postMessage(limite);

                    worker.onmessage = function(event) {
                        resultado.innerHTML = "<h3>Números primos:</h3>" + event.data.join(", ");
                    }

                    worker.onerror = function(error) {
                        resultado.innerHTML = "<span style='color:red;'>Error: " + error.message + "</span>";
                    }
                } else {
                    resultado.innerHTML = "Tu navegador no soporta Web Workers.";
                }
            } catch (e) {
                resultado.innerHTML = "Se produjo un error: " + e.message;
            }
        }
    </script>
</body>
</html>