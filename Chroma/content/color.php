<main>
    <form id="tableForm">
        <div class="tableForm_div"><label for="rc">Rows & Columns (1-26):</label>
        <input type="number" id="rc" name="rc"><br></div>
        <div class="tableForm_div"><label for="colors">Number of Colors (1-10):</label>
        <input type="number" id="colors" name="colors"><br></div>
        <input type="hidden" name="page" value="color.php">
        <div class="tableForm_div"><button type="submit" id="tableForm_button">Generate Tables</button><br></div>
    </form>
    <?php
        $rc = isset($_GET['rc']) ? $_GET['rc'] : null;
        $colors = isset($_GET['colors']) ? $_GET['colors'] : null;    

        $validity = true;
        if ($rc < 1 || $rc > 26) {
            $validity = false;
            echo "<p>Invalid row & column parameter, must be in between 1 and 26.</p><br>";
        } 
        if ($colors < 1 || $colors > 10) {
            $validity = false;
            echo "<p>Invalid color parameter, must be in between 1 and 10.</p><br>";
        } 
        if ($validity) {
            $color_options = ['red', 'orange', 'yellow', 'green', 'blue', 'purple', 'grey', 'brown', 'black', 'teal'];

            echo "<h2>Color Coordinate Generation</h2>";
            echo "<h3>Table with $colors colors</h3>";
            echo "<p id='colorError'></p>";
            echo "<table class='table_1' border='1'>";
            for ($i = 0; $i < $colors; $i++) {
                echo "<tr>";
                $i_1 = $i + 1;
                echo "<td width='20%'>Color $i_1</td>";
                echo "<td width='20%'><select class='colorSelectors' name='color$i'>";
                foreach ($color_options as $option) {
                    if ($option == $color_options[$i]) {
                        echo "<option value='$option' selected='true'>$option</option>";
                    } else {
                        echo "<option value='$option'>$option</option>";
                    }
                }
                echo "</select></td>";
                // Adding the radio
                $checked = $i === 0 ? "checked" : ""; // Default the first row's radio button to be checked
                echo "<td width='10%'><input type='radio' name='selectedColor' value='color$i' $checked></td>";
                echo "<td id='colorCoords$i' class='colorCoords'></td>"; // New column for coordinates
                echo "</tr>";
            }
            echo "</table>";
            echo "<h3>Coordinate Table</h3>";
            echo "<table class='table_2' border='1'>";
            echo "<tr><td></td>";
            for ($i = 0; $i < $rc; $i++) {
                echo "<td>" . chr(65 + $i) . "</td>";
            }
            echo "</tr>";
            for ($i = 0; $i < $rc; $i++) {
                echo "<tr>";
                echo "<td>" . ($i + 1) . "</td>";
                for ($j = 0; $j < $rc; $j++) {
                    echo "<td></td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } 
        else {
            exit;
        }
    ?>
    <div id="printableViewButton_div"><button id="printableViewButton">Printable View</button></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectors = document.querySelectorAll('.colorSelectors');
            const messageElement = document.getElementById('colorError');
            let selectedColors = {};
            let colorCoordinates = {};

            // initialize the radioButtons for setting table colors
            const radioButtons = document.querySelectorAll('input[type="radio"][name="selectedColor"]');
            let chosenColor = '';

            // function for updating, used for change in drop down
            function updateChosenColor() {
                radioButtons.forEach((radio, index) => {
                    if (radio.checked) {
                        chosenColor = selectedColors[`color${index}`];
                        console.log("Chosen Color updated to:", chosenColor); // console log for debugging
                    }
                })
            }

            // Function to update coordinates in the HTML
            function updateColorCoordinates(index) {
                const coordList = colorCoordinates[`color${index}`] || [];
                const sortedCoords = coordList.sort((a, b) => a.localeCompare(b)); // Sort coordinates lexicographically
                document.getElementById(`colorCoords${index}`).innerText = sortedCoords.join(', ');
            }    

            function updateCellColors(oldColor, newColor) {
                const tableCells = document.querySelectorAll('.table_2 td');
                tableCells.forEach(cell => {
                    if (cell.style.backgroundColor === oldColor) {
                        cell.style.backgroundColor = newColor;
                    }
                });
            }

            selectors.forEach((selector, index) => {
                const color = selector.value;
                selectedColors[`color${index}`] = selector.value;
                selector.setAttribute('data-prev', selector.value);
                colorCoordinates[`color${index}`] = []; // Initialize empty array for coordinates

                selector.addEventListener('change', function() {
                    const oldColor = selectedColors[`color${index}`];
                    const newColor = this.value;
                    
                    let validColor = true;

                    selectors.forEach((secondSelector, index) => {
                        if (secondSelector !== selector && newColor === selectedColors[`color${index}`]) {
                            validColor = false;
                        }
                    });
                    
                    if (!validColor) {
                        this.value = oldColor;
                        messageElement.textContent = "This color has already been selected. Please choose another.";
                        messageElement.style.display = "block";
                    } else {
                        selectedColors[`color${index}`] = newColor;
                        messageElement.style.display = 'none';

                        // Update chosen color if the current selectors radio button is checked
                        if (radioButtons[index].checked) {
                            updateChosenColor();
                        }

                        updateCellColors(oldColor, newColor);
                    }
                });
            });

            // set default chosen color before event listener (red)
            if (selectors.length > 0) {
                chosenColor = selectedColors[`color0`]
                console.log("Default Chosen Color:", chosenColor); // console log for debugging
            }

            // add event listener to radio buttons to update the color chosen by the radio button, will use for changing table
            radioButtons.forEach((radioButtons) => {
                radioButtons.addEventListener('change', function() {
                    if (this.checked) {
                        let index = parseInt(this.value.replace('color', ''));
                        chosenColor = selectedColors[`color${index}`]; // assign the color to selected
                        console.log("Chosen Color:", chosenColor); // console log for debugging
                    }
                });
            });

            // Adding click event listeners to cells in the coordinate table
            const tableCells = document.querySelectorAll('.table_2 td');
            tableCells.forEach(cell => {
                cell.addEventListener('click', function() {

                    if (!this.dataset.coord) { // Store coordinates data-attribute if not already set
                        const colIndex = this.cellIndex;
                        const rowIndex = this.parentNode.rowIndex;
                        this.dataset.coord = `${String.fromCharCode(65 + colIndex - 1)}${rowIndex}`; // Adjust column index for letter and row index for number
                    }

                    if (this.cellIndex != 0 && this.parentNode.rowIndex != 0) {
                        this.style.backgroundColor = chosenColor;
                        const colorIndex = [...radioButtons].findIndex(radio => radio.checked); // Find the index of the currently selected color
                        colorCoordinates[`color${colorIndex}`].push(this.dataset.coord); // Add coordinate to the color's array
                        updateColorCoordinates(colorIndex); // Update coordinates in the HTML
                        
                        console.log("coloring cell:", chosenColor); // console log for debugging
                    }
                });
            });

            document.getElementById('printableViewButton').addEventListener('click', function() {
                const rc = <?php echo json_encode($rc); ?>;
                const colors = <?php echo json_encode($colors); ?>;
                const params = new URLSearchParams({
                    rc, 
                    colors, 
                    selectedColors: JSON.stringify(selectedColors),
                    colorCoordinates: JSON.stringify(colorCoordinates)
                }).toString();
                window.location.href = `content/printableView.php?${params}`;
            });
        });
    </script>
</main>
