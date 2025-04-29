const numbers = [2, 5, 8, 10, 3];
// Результат после map: [6, 15, 24, 30, 9]
// Результат после filter: [15, 24, 30]
console.log(numbers.map(n => n * 3).filter(n => n > 10));