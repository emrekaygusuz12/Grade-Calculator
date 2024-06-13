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
        }
        h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        select {
            width: 7%;
            padding: 5px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="number"], input[type="text"] {
            width: 15%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="button"] {
            width: 15%;
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
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .assignment-row > * {
            flex: 1;
            margin: 0 5px;
        }
        .assignment-row input[type="number"], .assignment-row input[type="checkbox"] {
            width: 80px;
        }
        .assignment-row input[type="number"]:not([type="text"]) {
            width: 60px;
        }

    </style>
    <script>
        // Function to dynamically generate assignment inputs
        function generateAssignments() {
            let numAssignments = document.getElementById("numAssignments").value;
            let assignmentsContainer = document.getElementById("assignmentsContainer");
            let assignmentHeader = document.getElementById("assignmentHeader");
            let assignmentCalculate = document.getElementById("assignmentCalculate");
            
            // Clear previous assignments
            assignmentsContainer.innerHTML = '';
            
            if (numAssignments >= 1) {
                assignmentHeader.style.display = 'block';
                assignmentCalculate.style.display = 'block'; // Show submit button
                for (let i = 1; i <= numAssignments; i++) {
                    let assignmentRow = document.createElement('div');
                    assignmentRow.id = `assignmentRow${i}`;
                    assignmentRow.classList.add('assignment-row');
                    assignmentRow.innerHTML = `
                        <p>Assignment ${i}:</p>
                        <input type="number" name="score${i}" id="score${i}" min="0" max="100" oninput="calculateGrade(${i})" placeholder="Score"> /
                        
                        <input type="number" name="total${i}" id="total${i}" min="0" max="100" oninput="calculateGrade(${i})" placeholder="Out of"> |
                        <input type="number" name="grade${i}" id="grade${i}" min="0" max="100" step="0.01" oninput="manualGradeInput(${i})" placeholder="Grade"> |
                        <input type="number" name="weight${i}" id="weight${i}" min="0" max="100" step="0.01" placeholder="Weight">
                    `;
                    assignmentsContainer.appendChild(assignmentRow);
                }
            } else {
                assignmentHeader.style.display = 'none';
                assignmentCalculate.style.display = 'none'; // Hide submit button
            }
        }

        // Function to calculate grade percentage
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

        // Function to handle manual grade input
        function manualGradeInput(assignmentNumber) {
            let grade = document.getElementById(`grade${assignmentNumber}`);
            
            if (grade.value < 0 || grade.value > 100) {
                grade.value = '';
            }
        }

        // Function to calculate the final grade
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
            if (totalWeight > 0) {
                let finalGrade = weightedGradeSum / totalWeight;
                finalGradeBox.value = `${finalGrade.toFixed(2)}%`;
            } else {
                finalGradeBox.value = "Invalid weights";
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
            <!-- Assignment inputs will be generated here -->
        </div>

        <div id="assignmentCalculate" style="display: none;">
            <p><input type="button" value="Calculate" onclick="calculateFinalGrade()"></p>
            <p>Your final grade: <input type="text" id="finalGrade" readonly></p>
        </div>
    </div>
</body>
</html>
