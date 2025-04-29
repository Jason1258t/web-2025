function countVowels(str) {
    const vowels = 'аеёиоуыэюя';
    let cnt = 0;
    const foundVowels = [];

    for (let char of str) {
        if (vowels.includes(char)) {
            cnt++;
            foundVowels.push(char);
        }
    }
    return {count: cnt, foundVowels: foundVowels};
}

console.log(countVowels("Привет, мир!"));