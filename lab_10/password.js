import { generate } from "generate-password";

const password = generate({
  length: 12,
  numbers: true,
  symbols: true,
  uppercase: true,
  lowercase: true,
  excludeSimilarCharacters: true,
  strict: true // Гарантирует наличие всех типов символов
});

console.log(password); // Например: "H7@k9Lm4#pX2"