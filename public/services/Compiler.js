const languageMap = {
  csharp: 51,
  cpp: 54,
  python: 71,
  java: 62
};

//192.168.100.2
//192.168.123.51
//192.168.68.113
const ip = '192.168.68.113:2358';

const callback = ({ apiStatus, data, message, allTestsPassed }) => {
  const outputEl = document.getElementById("output");
  const progressBar = document.getElementById("progressBar");
  const submitBtn = document.querySelector('#btn-submit');
  const totalTests = document.querySelectorAll('#accordionCustomIcon .accordion-header i').length;

  if (apiStatus === 'loading') {
    updateProgressBar('50%', true);
    outputEl.value = "Running...";
  } else if (apiStatus === 'error') {
    updateProgressBar('0%', false);
    outputEl.value = message;
    showToast('Error', message, 'error');
  } else if (apiStatus === 'success') {
    handleSuccessResponse(data, submitBtn, allTestsPassed, outputEl);
    updateProgressBar('100%', false);
    if (allTestsPassed) {
      showToast('Success', 'All tests passed successfully', 'success');
    } else {
      showToast('Warning', 'Some tests did not pass', 'warning');
    }
  }
};

const showToast = (title, message, type) => {
  const toastContainer = document.getElementById('toastContainer');

  const toastEl = document.createElement('div');
  toastEl.className = `toast`;
  toastEl.setAttribute('role', 'alert');
  toastEl.setAttribute('aria-live', 'assertive');
  toastEl.setAttribute('aria-atomic', 'true');

  // Color mapping
  const colorMap = {
    success: { bg: 'bg-success', text: 'text-white', icon: 'fa-circle-check' },
    warning: { bg: 'bg-warning', text: 'text-dark', icon: 'fa-triangle-exclamation' },
    error: { bg: 'bg-danger', text: 'text-white', icon: 'fa-circle-xmark' }
  };

  toastEl.innerHTML = `
    <div class="toast-header ${colorMap[type].bg} ${colorMap[type].text}">
      <i class="fas ${colorMap[type].icon} me-2"></i>
      <strong class="me-auto">${title}</strong>
      <small class="text-muted">Just now</small>
      <button type="button" class="btn-close ${type === 'warning' ? '' : 'btn-close-white'}" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      ${message}
    </div>
  `;

  toastContainer.appendChild(toastEl);

  const toast = new bootstrap.Toast(toastEl, {
    animation: true,
    autohide: true,
    delay: 3000
  });

  // Add entrance animation
  toastEl.style.transform = 'translateX(100%)';
  setTimeout(() => {
    toastEl.style.transition = 'transform 0.3s ease-out';
    toastEl.style.transform = 'translateX(0)';
  }, 10);

  toastEl.addEventListener('hidden.bs.toast', () => {
    toastEl.remove();
  });

  toast.show();

  // Success celebration
  if (type === 'success') {
    triggerConfetti();
  }
};

const triggerConfetti = () => {
  const defaults = {
    spread: 60,
    ticks: 100,
    gravity: 0,
    decay: 0.94,
    startVelocity: 30,
    colors: ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'],
    shapes: ['star', 'circle'],
    scalar: 1.2
  };

  confetti({
    ...defaults,
    particleCount: 50,
    origin: { x: 0.8, y: 0.1 }
  });

  confetti({
    ...defaults,
    particleCount: 50,
    origin: { x: 0.2, y: 0.1 }
  });
};

const updateProgressBar = (width, isAnimating) => {
  const progressBar = document.getElementById("progressBar");
  progressBar.style.width = width;
  if (isAnimating) {
    progressBar.classList.add("progress-bar-striped", "progress-bar-animated");
  } else {
    progressBar.classList.remove("progress-bar-striped", "progress-bar-animated");
  }
};

const handleSuccessResponse = (data, submitBtn, allTestsPassed, outputEl) => {
  let output = getOutput(data);
  outputEl.value = output;
  const solutionEl = document.getElementById('solution').value;
  
  if (solutionEl) {
    solutionEl.value = editor.getValue();
  }
 
  toggleSubmitButton(submitBtn, allTestsPassed);
};

const getOutput = (data) => {
  if (data.status.id === 3) {
    return atob(data.stdout);
  } else {
    return atob(data.compile_output || data.stderr || data.message || "Program did not finish successfully.");
  }
};

const toggleSubmitButton = (submitBtn, allTestsPassed) => {
  if (submitBtn) {
    submitBtn.disabled = !allTestsPassed;
  } else {
    console.error("Submit button not found");
  }
};

const makeBatchSubmission = async (code, language, inputs) => {
  const submissions = inputs.map(input => ({
    language_id: languageMap[language],
    source_code: btoa(code),
    stdin: btoa(input),
  }));

  const response = await sendRequest(`http://${ip}/submissions/batch?base64_encoded=true`, 'POST', { submissions });
  const tokens = response.map(s => s.token).join(',');
  return tokens;
};

const sendRequest = async (url, method, body = null) => {
  const options = {
    method,
    headers: {
      'X-Auth-Token': 'your-token',
      'Content-Type': 'application/json',
    },
    body: body ? JSON.stringify(body) : null,
  };

  try {
    const response = await fetch(url, options);
    return await response.json();
  } catch (error) {
    throw new Error(`Request failed: ${error.message}`);
  }
};

const getSubmission = async (token) => {
  const url = `http://${ip}/submissions/${token}?base64_encoded=true&fields=*`;
  return await sendRequest(url, 'GET');
};

const makeSubmission = async (code, language, callback, stdin) => {
  const url = `http://${ip}/submissions?base64_encoded=true&wait=true&fields=*`;
  const requestBody = {
    language_id: languageMap[language],
    source_code: btoa(code),
    stdin: btoa(stdin),
  };

  try {
    callback({ apiStatus: 'loading' });
    const response = await sendRequest(url, 'POST', requestBody);
    await processSubmission(response.token, callback);
  } catch (error) {
    callback({ apiStatus: 'error', message: error.message });
  }
};

const processSubmission = async (token, callback) => {
  let status_id = 1;
  while ([1, 2].includes(status_id)) {
    try {
      const result = await getSubmission(token);
      status_id = result.status.id;
      if (status_id === 3) {
        callback({ apiStatus: 'success', data: result });
      }
    } catch (error) {
      callback({ apiStatus: 'error', message: error.message });
      break;
    }
  }
};

const runCode = () => {
  const language = document.getElementById("languageSelector").value;
  const code = editor.getValue();
  const stdin = document.getElementById("argsInput").value ?? '';
  makeSubmission(code, language, callback, stdin);
};

const runBatchCode = async () => {
  const language = document.getElementById("languageSelector").value;
  const code = editor.getValue();
  const testCaseElements = document.querySelectorAll('#accordionCustomIcon .accordion-item');
  const inputs = [];
  const expectedOutputs = [];

  testCaseElements.forEach(item => {
    inputs.push(item.querySelector('textarea').value);
    expectedOutputs.push(item.querySelectorAll('textarea')[1].value);
  });

  callback({ apiStatus: 'loading' });

  try {
    const tokens = await makeBatchSubmission(code, language, inputs);
    const results = await pollBatchResults(tokens);
    const testResultsMatch = await compareBatchResults(results, expectedOutputs);

    updateTestCases(testCaseElements, results, testResultsMatch);
    const allTestsPassed = testResultsMatch.every(result => result === true);
    callback({ apiStatus: 'success', data: results[0], allTestsPassed });

  } catch (error) {
    callback({ apiStatus: 'error', message: error.message });
  }
};

const compareBatchResults = async (results, expectedOutputs) => {
  return await Promise.all(results.map((submission, index) => {
    const actual = submission.stdout || submission.stderr || submission.compile_output || '';
    return compareOutput(expectedOutputs[index], actual);
  }));
};

const compareOutput = (expectedOutput, actualOutput) => {
  const expected = expectedOutput.trim().replace(/\r\n/g, '\n');
  const actual = atob(actualOutput).trim().replace(/\r\n/g, '\n');
  return expected === actual;
};

const updateTestCases = (testCaseElements, results, testResultsMatch) => {
  testCaseElements.forEach((item, index) => {
    const output = results[index].stdout || results[index].stderr || results[index].compile_output || 'Tm8gb3V0cHV0';
    const textareas = item.querySelectorAll('textarea');
    const outputField = textareas[2];
    const iconField = item.querySelectorAll('i');

    if (outputField) {
      outputField.value = atob(output);
    } else {
      console.error(`Output field not found for test case at index ${index}`);
    }

    changeTestIcon(index, testResultsMatch, iconField);
  });
};

function countPassedTests() {
  const icons = document.querySelectorAll('#accordionCustomIcon .accordion-header i');

  let passedCount = 0;
  icons.forEach(icon => {
    if (icon.classList.contains('fa-circle-check') && icon.classList.contains('text-success')) {
      passedCount++;
    }
  });

  return passedCount;
}

const changeTestIcon = (index, testResultsMatch, iconField) => {
  iconField[0].classList.remove('fa-circle-check', 'text-success', 'fa-circle-xmark', 'text-danger');
  iconField[0].classList.add(...(testResultsMatch[index] ? ['fa-circle-check', 'text-success'] : ['fa-circle-xmark', 'text-danger']));

  const passedTests = countPassedTests();

  const progressBar = document.getElementById('progressBar');
  const totalTests = document.querySelectorAll('#accordionCustomIcon .accordion-header i').length;

  if (progressBar) {
    const percentage = (passedTests / totalTests) * 100;
    progressBar.style.width = percentage + '%';
    progressBar.setAttribute('aria-valuenow', percentage);
  }


  const totalScoreLabel = document.getElementById('totalScoreLabel');
  if (totalScoreLabel) {
    totalScoreLabel.textContent = `Total Score: ${passedTests} / ${totalTests}`;
  }

  const scoreInput = document.querySelector('input[name="score"]');
  if (scoreInput) {
    scoreInput.value = passedTests;
  }
};

const pollBatchResults = async (tokens) => {
  const tokenArray = tokens.split(',');
  const results = [];
  const maxRetries = 10;
  const delay = 2000;

  for (let i = 0; i < maxRetries; i++) {
    results.length = 0;

    for (const token of tokenArray) {
      const result = await getSubmission(token);
      results.push(result);
    }

    if (results.every(submission => submission.status.id !== 1 && submission.status.id !== 2)) {
      return results;
    }

    await new Promise(resolve => setTimeout(resolve, delay));
  }

  throw new Error('Batch submissions did not complete within the maximum retries.');
};