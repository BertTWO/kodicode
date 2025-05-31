// typing-effect.js

document.addEventListener("DOMContentLoaded", function () {
    new Typed("#typed-text", {
      strings: [
        "Welcome to CodeZilla",
        "FixMy code works... I have no idea why.",
        "Ctrl + C, Ctrl + V",
        "I fixed the bug... but now nothing works"
      ],
      typeSpeed: 50,
      backSpeed: 25,
      backDelay: 1500,
      loop: true,
      smartBackspace: true,
      showCursor: true,
      cursorChar: "|"
    });
  });
  