function esPrimo(n) {
    if (n <= 1) return false;
    for (let i = 2; i <= Math.sqrt(n); i++) {
        if (n % i === 0) return false;
    }
    return true;
}

self.onmessage = function(e) {
    const limite = parseInt(e.data);
    let primos = [];
    let contador = 0;
    let numero = 2;

    try {
        while (contador < 300 && numero <= limite) {
            if (esPrimo(numero)) {
                primos.push(numero);
                contador++;
            }
            numero++;
        }

        self.postMessage(primos);
    } catch (error) {
        self.postMessage({ error: error.message });
    }
}