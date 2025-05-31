
document.getElementById('searchInput').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#problemTable tr');

    rows.forEach(row => {
        const title = row.querySelector('td:first-child').textContent.toLowerCase();
        row.style.display = title.includes(searchValue) ? '' : 'none';
    });
});


document.getElementById('allSearchInput').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#allProblemTable tr');

    rows.forEach(row => {
        const title = row.querySelector('td:first-child').textContent.toLowerCase();
        row.style.display = title.includes(searchValue) ? '' : 'none';
    });
});

// Refresh the page to reload problems
function refreshProblems() {
    location.reload();
}
document.addEventListener('DOMContentLoaded', function () {
    const stepper = new Stepper(document.querySelector('.bs-stepper'));

    document.querySelectorAll('.btn-next').forEach(btn => {
        btn.addEventListener('click', () => stepper.next());
    });

    document.querySelectorAll('.btn-prev').forEach(btn => {
        btn.addEventListener('click', () => stepper.previous());
    });

    const exampleContainer = document.getElementById('exampleContainer');
    const addExampleBtn = document.getElementById('addExampleBtn');

    addExampleBtn.addEventListener('click', function () {
        const card = document.createElement('div');
        card.classList.add('card', 'mb-3', 'example-pair', 'shadow-sm', 'p-3');
        card.innerHTML = `
        <div class="mb-2">
            <textarea name="example[]" style='background-color: #282a36; color: #fff;' class="form-control" rows="3" placeholder="e.g. 2 4 6"></textarea>
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm remove-example">
            <i class="bi bi-x-circle"></i> Remove Example
        </button>
    `;
        exampleContainer.appendChild(card);
    });


    exampleContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-example') || e.target.closest('.remove-example')) {
            e.target.closest('.example-pair').remove();
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const testCaseContainer = document.getElementById('accordionCustomIcon');
    const addTestCaseBtn = document.getElementById('addTestCaseBtn');
    const resetTestCaseBtn = document.getElementById('resetTestCaseBtn');
    const runBatchBtn = document.getElementById('btnRunBatch');

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

    addTestCase(0);

    // Handle adding new test cases
    addTestCaseBtn.addEventListener('click', function () {
        const index = testCaseContainer.querySelectorAll('.accordion-item').length;
        addTestCase(index);
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
document.addEventListener('DOMContentLoaded', function () {
    const runBatchBtn = document.querySelector('#btnRunBatch');

    runBatchBtn.addEventListener('click', function () {
        console.log("running...");
        runBatchCode();
    });

});
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll('.confirm-delete');
    console.log(deleteButtons, "nigga");
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-1',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

