function uniqueElements(arr) {
    const elements = {};
    for (let i of arr) {
        let key = String(i);
        elements[key] = (elements[key] ?? 0) + 1;
    }

    return elements;
}

console.log(uniqueElements(['привет', 'hello', 1, '1'])); // {'привет': 1, 'hello': 1, '1': 2}