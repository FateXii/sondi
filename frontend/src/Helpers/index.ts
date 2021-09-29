import { List } from "@/Types";

export function capitalize(word: string) {
  const [firstLetter, ...restOfWord] = word.split("");
  return [firstLetter.toUpperCase(), restOfWord.join("")].join("");
}

export function titleCase(sentence: string) {
  const words = sentence.split(" ");
  return words.map((word) => capitalize(word)).join(" ");
}

export function NewList<T>(): List<T> {
  return { list: [] };
}
