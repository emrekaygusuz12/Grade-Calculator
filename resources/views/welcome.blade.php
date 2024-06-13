<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Calculator</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 700px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        select {
            width: 12%;
            padding: 5px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="number"], input[type="text"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            text-align: center;
            width: 140px;
        }
        input[type="button"] {
            width: 25%;
            padding: 5px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="button"]:hover {
            background-color: #45a049;
        }
        .assignment-row {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
            width: 400px;
        }
        .assignment-row > * {
            margin: 0 5px;
        }
        .assignment-row input[type="number"], .assignment-row input[type="checkbox"] {
            width: 50px;
            text-align: center;
        }
        .assignment-row input[type="number"]:not([type="text"]) {
            width: 80px;
            text-align: center;
        }
        .separator {
            margin: 0 10px;
        }

        /* Hide the up and down arrows for number inputs */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
    <script>
        function generateAssignments() {
            let numAssignments = document.getElementById("numAssignments").value;
            let assignmentsContainer = document.getElementById("assignmentsContainer");
            let assignmentHeader = document.getElementById("assignmentHeader");
            let assignmentCalculate = document.getElementById("assignmentCalculate");
            
            assignmentsContainer.innerHTML = '';
            document.getElementById("finalGrade").value = '';
            document.getElementById("finalGradeText").textContent = '';
            
            if (numAssignments >= 1) {
                assignmentHeader.style.display = 'block';
                assignmentCalculate.style.display = 'block';
                for (let i = 1; i <= numAssignments; i++) {
                    let assignmentRow = document.createElement('div');
                    assignmentRow.id = `assignmentRow${i}`;
                    assignmentRow.classList.add('assignment-row');
                    assignmentRow.innerHTML = `
                        <p>Assignment${i}:</p>
                        <input type="number" name="score${i}" id="score${i}" min="0" max="100" oninput="calculateGrade(${i})" placeholder="Score">
                        <span class="separator">/</span>
                        <input type="number" name="total${i}" id="total${i}" min="0" max="100" oninput="calculateGrade(${i})" placeholder="Out of">
                        <span class="separator">|</span>
                        <input type="number" name="grade${i}" id="grade${i}" min="0" max="100" step="0.01" oninput="manualGradeInput(${i})" placeholder="Grade">
                        <span class="separator">|</span>
                        <input type="number" name="weight${i}" id="weight${i}" min="0" max="100" step="0.01" placeholder="Weight">
                    `;
                    assignmentsContainer.appendChild(assignmentRow);
                }
            } else {
                assignmentHeader.style.display = 'none';
                assignmentCalculate.style.display = 'none';
            }
        }

        function calculateGrade(assignmentNumber) {
            let score = document.getElementById(`score${assignmentNumber}`).value;
            let total = document.getElementById(`total${assignmentNumber}`).value;
            let grade = document.getElementById(`grade${assignmentNumber}`);

            if (score && total && total != 0) {
                let percentage = (score / total) * 100;
                grade.value = percentage.toFixed(2);
            } else {
                grade.value = '';
            }
        }

        function manualGradeInput(assignmentNumber) {
            let grade = document.getElementById(`grade${assignmentNumber}`);
            
            if (grade.value < 0 || grade.value > 100) {
                grade.value = '';
            }
        }

        function calculateFinalGrade() {
            let numAssignments = document.getElementById("numAssignments").value;
            let totalWeight = 0;
            let weightedGradeSum = 0;
            
            for (let i = 1; i <= numAssignments; i++) {
                let grade = parseFloat(document.getElementById(`grade${i}`).value);
                let weight = parseFloat(document.getElementById(`weight${i}`).value);
                
                if (!isNaN(grade) && !isNaN(weight)) {
                    weightedGradeSum += grade * weight;
                    totalWeight += weight;
                }
            }

            let finalGradeBox = document.getElementById("finalGrade");
            let finalGradeText = document.getElementById("finalGradeText");
            if (totalWeight > 0) {
                let finalGrade = weightedGradeSum / totalWeight;
                finalGradeBox.value = `${finalGrade.toFixed(2)}%`;
                
                let gradeText = "";
                if (finalGrade >= 70) {
                    gradeText = "1st";
                } else if (finalGrade >= 60) {
                    gradeText = "2:1";
                } else if (finalGrade >= 50) {
                    gradeText = "2:2";
                } else if (finalGrade >= 40) {
                    gradeText = "3rd";
                } else {
                    gradeText = "Fail";
                }
                finalGradeText.textContent = gradeText;
            } else {
                finalGradeBox.value = "Invalid weights";
                finalGradeText.textContent = "";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Welcome to Grade Calculator!</h1>
        <p>
            Please select the number of assignments: 
            <select id="numAssignments" name="assignments" onchange="generateAssignments()"> 
                @for ($i = 0; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </p><br>

        <div id="assignmentHeader" style="display: none;">
        </div>

        <div id="assignmentsContainer">
        </div>

        <div id="assignmentCalculate" style="display: none;">
            <p><input type="button" value="Calculate" onclick="calculateFinalGrade()"></p>
            <p>Your final grade: <input type="text" id="finalGrade" readonly></p>
            <p>Grade classification: <span id="finalGradeText"></span></p>
        </div>
    </div>
</body>
</html>
