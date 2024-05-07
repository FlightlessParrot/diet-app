export function useCapitalizeFirstLetterOfEveryWord(words)
{
    const splitBySpace = words.split(" ")
    const capitalizedWordsArray= splitBySpace.map(word => {
        word=word[0].toUpperCase()+word.substr(1);
        return word;
    });
    const capitalizeWords = capitalizedWordsArray.join(" ");
    return capitalizeWords;
}