//edit problem
document.addEventListener("DOMContentLoaded", function () {
    const exampleEditContainer = document.getElementById('editExampleContainer');
    const addEditExampleBtn = document.getElementById('addEditExample');

    console.log(exampleEditContainer, "exampleEditContainer");
    // Add new example card
    addEditExampleBtn.addEventListener('click', function () {
        const card = document.createElement('div');
        card.classList.add('card','border','rounded','shadow-sm', 'mb-3', 'example-pair', 'shadow-sm', 'p-3');
        card.innerHTML = `
            <div class="mb-2">
                <textarea name="example[]" style="background-color: #282a36; color: #fff;" class="form-control" rows="3" placeholder="e.g. 2 4 6"></textarea>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm remove-edit-example">
                <i class="bi bi-x-circle"></i> Remove Example
            </button>
        `;
        exampleEditContainer.appendChild(card);
    });

    // Delegate remove event to dynamically and initially loaded buttons
    exampleEditContainer.addEventListener('click', function (e) {
        if (e.target.closest('.remove-edit-example')) {
            const card = e.target.closest('.example-pair');
            if (card) {
                card.remove();
            }
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const testCaseContainer = document.getElementById('accordionCustomIcon');
    const addTestCaseBtn = document.getElementById('addTestCaseBtn');
    const resetTestCaseBtn = document.getElementById('resetTestCaseBtn');

    // Function to dynamically add test cases
    function addTestCase(index, input = '', expectedOutput = '') {
        const accordionId = `accordionCustomIcon-${index}`;
        const card = document.createElement('div');
        card.classList.add('accordion-item');
        card.innerHTML = `
            <h2 class="accordion-header text-body d-flex justify-content-between align-items-center">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#${accordionId}" aria-controls="${accordionId}" aria-expanded="false">
                    <i class="icon-base me-2 fas fa-circle-minus text-secondary"></i>
                    Test Case ${index + 1}
                </button>
            </h2>
            <div id="${accordionId}" class="accordion-collapse collapse" data-bs-parent="#accordionCustomIcon">
                <div class="accordion-body">
                    <label class="form-label fw-bold text-white small">Input</label>
                    <textarea name="input[]" class="form-control text-white border-0 mb-2 small" style="resize: none; background-color: #282a36; font-size: 0.85rem;" placeholder="e.g., 1 2 3">${input}</textarea>

                    <label class="form-label fw-bold text-white small">Expected Output</label>
                    <textarea name="expectedOutput[]" class="form-control text-white border-0 mb-2 small" style="resize: none; background-color: #282a36; font-size: 0.85rem;" placeholder="e.g., 6">${expectedOutput}</textarea>

                    <label class="form-label fw-bold text-white small">Your Output</label>
                    <textarea class="form-control text-white border-0 small" disabled style="resize: none; background-color: #282a36; font-size: 0.85rem;"></textarea>
                </div>
            </div>
        `;
        testCaseContainer.appendChild(card);
    }

    // Get the initial number of test cases already loaded in the DOM
    const initialTestCaseCount = testCaseContainer.querySelectorAll('.accordion-item').length;

    // Handle adding new test cases
    addTestCaseBtn.addEventListener('click', function () {
        const index = testCaseContainer.querySelectorAll('.accordion-item').length; // Get the current number of test cases
        addTestCase(index); // Add a new test case after the existing ones
        testCaseContainer.lastElementChild.scrollIntoView({
            behavior: "smooth"
        });
    });

    // Handle resetting test cases
    resetTestCaseBtn.addEventListener('click', function () {
        testCaseContainer.innerHTML = '';
        addTestCase(0); // Add one initial test case
    });
});