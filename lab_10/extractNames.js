const users = [
    { id: 1, name: "Alice" },
    { id: 2, name: "Bob" },
    { id: 3, name: "Charlie" }
  ];
  // Результат: ["Alice", "Bob", "Charlie"]

function extractNames(users) {
    return users.map(user => user.name);
}
console.log(extractNames(users));