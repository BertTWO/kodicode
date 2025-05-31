let editor;
let defaultLanguage = "csharp"

const aceModeMap = {
  cpp: "c_cpp",
  csharp: "csharp",
  python: "python",
  java: "java"
};

window.addEventListener('DOMContentLoaded', async () => {

  await initializeEditor();

  const initialLang = getSelectedLanguage();
  await setEditorLanguage(initialLang);
});


async function initializeEditor() {
  editor = ace.edit("code-editor", {
    mode: `ace/mode/${aceModeMap[defaultLanguage]}`,
    theme: "ace/theme/dracula",
    fontSize: "16px",
    wrap: true,
    useWorker: false,
  });
}

function resetEditor() {
  const lang = getSelectedLanguage();
  setEditorLanguage(lang);
}


async function changeLanguage() {
  const lang = getSelectedLanguage();
  setCode = "";

  await setEditorLanguage(lang);
}


function getSelectedLanguage() {
  return document.getElementById("languageSelector").value;
}

async function setEditorLanguage(lang) {

  const extensionMap = {
    cpp: "cpp",
    csharp: "cs",
    python: "py",
    java: "java"
  };
  const selectedLanguageElement = document.getElementById('selectedLanguage');
  if (selectedLanguageElement) {
    selectedLanguageElement.value = extensionMap[lang];
  }

  const languageMap = {
    "C#": "csharp",
    "C++": "cpp",
    "Python": "python",
    "Java": "java"
  };

  const normalizedLang = languageMap[setLanguage];

  if (setCode !== "" && normalizedLang) {
    editor.setValue(setCode, -1);
  } else {
    editor.setValue(await getDefaultCode(aceModeMap[lang]), -1);
  }

}

document.querySelector("form").addEventListener("submit", function (e) {
  const code = editor.getValue();
  document.getElementById("solution").value = code;
});

async function getDefaultCode(lang) {
  const samples = {
    c_cpp: `#include <iostream>
  
     int main() {
       std::cout << "Hello, world!" << std::endl;
       return 0;
     }`,
    csharp: `using System;
  
class Program {
    static void Main(string[] args) {
        Console.WriteLine("Hello, world!");
    }
}`,
    java: `public class Main {
    public static void main(String[] args) {
        System.out.println("Hello, world!");
    }
}`,
    python: `print("Hello, world!")`
  };

  return new Promise(resolve => setTimeout(() => resolve(samples[lang] || ""), 100));
}
