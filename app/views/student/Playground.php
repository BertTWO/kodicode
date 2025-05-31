<div class="card shadow-sm ">
  <div class="card-body">
    <div class="row align-items-end mb-3">
      <div class="col-md-10">
        <h4 class="card-title text-white mb-2">Code Playground</h4>
        <p class="text-muted mb-0">Write and test your code below.</p>
      </div>
      <div class="col-md-2 mt-3 mt-md-0">
             <input type="hidden" id="solution" name="solution">
        <select id="languageSelector" class="form-select text-white border-secondary" onchange="changeLanguage()">
          <option value="cpp">C++</option>
          <option value="csharp">C#</option>
          <option value="java">Java</option>
          <option value="python">Python</option>
        </select>
      </div>
    </div>

    <!-- Code Editor -->
    <div id="code-editor" class="border rounded " style="height: 350px;"></div>

    <!-- Input Arguments -->
    <div class="mt-4">
      <label for="argsInput" class="form-label text-white fs-5">Input</label>
      <textarea id="argsInput" class="form-control text-white border-0" rows="3"
        style="resize: none; background-color: #282a36;" placeholder="e.g., 5 10"></textarea>
      <small class="form-text text-muted">Separate multiple inputs with spaces.</small>
    </div>

    <!-- Buttons -->
    <div class="mt-4 d-flex flex-wrap gap-2">
      <button class="btn btn-primary" onclick="runCode()">▶ Run Code</button>
      <button class="btn btn-outline-light" onclick="resetEditor()">↺ Reset</button>
    </div>

    <!-- Progress Bar -->
    <div class="progress mt-3" style="height: 6px;">
      <div class="progress-bar bg-success" id="progressBar" role="progressbar"
        style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <!-- Output -->
    <div class="mt-5">
      <h5 class="text-white mb-2">Output:</h5>
      <textarea id="output" disabled class="form-control text-white border-0"
        style="resize: none; background-color: #282a36; height: 250px;"></textarea>
    </div>
  </div>
</div>
