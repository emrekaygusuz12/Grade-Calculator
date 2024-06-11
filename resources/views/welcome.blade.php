<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Calculator</title>
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
                for (let i = 1; i <= numAssignments; i++) {
                    let assignmentRow = document.createElement('div');
                    assignmentRow.id = `assignmentRow${i}`;
                    assignmentRow.innerHTML = `
                        <p>
                            Assignment ${i}: 
                            <input type="number" name="score${i}" id="score${i}" min="0" max="255"> / 
                            <input type="number" name="total${i}" id="total${i}" min="0" max="255"> | 
                            <input type="number" name="grade${i}" id="grade${i}" min="0" max="100" step="0.01"> | 
                            <input type="number" name="weight${i}" id="weight${i}" min="0" max="100" step="0.01">
                        </p>`;
                    assignmentsContainer.appendChild(assignmentRow);
                }
            } else {
                assignmentHeader.style.display = 'none';
            }
        }
    </script>
</head>
<body>
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
        @php
            echo str_repeat('&nbsp;', 25); echo "Your Score / Total Score"; echo str_repeat('&nbsp;', 6); echo "Grade (%)"; echo str_repeat('&nbsp;', 9); echo "Weight (%)";
        @endphp
    </div>

    <div id="assignmentCalculate" style="display: none;">
        <p><input type="submit" value= "Submit"> </p>
    </div>
    
    <div id="assignmentsContainer">
        <!-- Assignment inputs will be generated here -->
    </div>
</body>
</html>
