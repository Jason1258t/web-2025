function isPrimeNumber(input) {
    if (typeof input === 'number') {
        return handleNum(input);
    } else if (Array.isArray(input) && input.every(item => typeof item === 'number')) {
        return handleArray(input);
    } else {
        console.error('Ошибка: параметр должен быть числом или массивом чисел.');
    }
}

function handleNum(num) {
    const prime = isPrime(num);
    if (prime) {
        console.log(`${num} простое число`);
    } else {
        console.log(`${num} не простое число`);
    }
    return prime;
}

function handleArray(nums) {
    const primes = [];
    const nonPrimes = [];

    nums.forEach(num => {
        if (isPrime(num)) {
            primes.push(num);
        } else {
            nonPrimes.push(num);
        }
    });

    const message = formatMessageForArray(primes, nonPrimes);
    console.log(message);
    return primes;
}

function isPrime(num) {
    if (num <= 1) return false;
    if (num === 2) return true;

    const sqrtNum = Math.sqrt(num);
    for (let i = 2; i <= sqrtNum; i++) {
        if (num % i === 0) return false;
    }
    return true;
}

function formatMessageForArray(primes, nonPrimes) {
    let message = '';
    if (primes.length > 0) {
        message += `${primes.join(', ')} ${primes.length === 1 ? 'простое число' : 'простые числа'}`;
    }
    if (nonPrimes.length > 0) {
        if (message.length > 0) {
            message += ', ';
        }
        message += `${nonPrimes.join(', ')} ${nonPrimes.length === 1 ? 'не простое число' : 'не простые числа'}`;
    }

    return message;
}

isPrimeNumber(3)              // Результат: 3 простое число
isPrimeNumber(4)              // Результат: 4 не простое число
isPrimeNumber([3, 4, 5])      // Результат: 3, 5 простые числа, 4 не простое число