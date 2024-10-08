<main>
    <form id="tableForm">
        <div class="tableForm_div"><label for="rc">Rows & Columns (1-26):</label>
        <input type="number" id="rc" name="rc"><br></div>
        <div class="tableForm_div"><label for="num_colors">Number of Colors:</label>
        <input type="number" id="num_colors" name="num_colors"><br></div>
        <input type="hidden" name="page" value="color.php">
        <div class="tableForm_div"><button type="submit" id="tableForm_button">Generate Tables</button><br></div>
    </form>
    <?php
        ob_start();
        include 'get_colors.php';
        $color_json = ob_get_clean();
        $color_options = json_decode($color_json, true);
    
        $rc = isset($_GET['rc']) ? $_GET['rc'] : null;
        $num_colors = isset($_GET['num_colors']) ? $_GET['num_colors'] : null;    

        $validity = true;
        if ($rc < 1 || $rc > 26) {
            $validity = false;
            echo "<p>Invalid row & column parameter, must be in between 1 and 26.</p><br>";
        } 
        if ($num_colors < 1 || $num_colors > count($color_options)) {
            $validity = false;
            echo "<p>Invalid color parameter.</p><br>";
        } 
        if (empty($color_options)) {
            $validity = false;
            echo "<p>Color table is empty.</p><br>";
        }
        if ($validity) {
            echo "<h2>Color Coordinate Generation</h2>";
            echo "<h3>Table with $num_colors colors</h3>";
            echo "<p id='colorError'></p>";
            echo "<table class='table_1' border='1'>";
            for ($i = 0; $i < $num_colors; $i++) {
                echo "<tr>";
                $i_1 = $i + 1;
                echo "<td width='20%'>Color $i_1</td>";
                echo "<td width='20%'><select class='colorSelectors' name='color$i'>";
                foreach ($color_options as $option) {
                    if ($option == $color_options[$i]) {
                        echo "<option value='{$option['name']}' selected='true'>{$option['name']}</option>";
                    } else {
                        echo "<option value='{$option['name']}'>{$option['name']}</option>";
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

            // initialize the radioButtons for setting table num_colors
            const radioButtons = document.querySelectorAll('input[type="radio"][name="selectedColor"]');
            let chosenColor = '';

            // function for updating cells already colored, used for change in drop down
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
                        const coord = this.dataset.coord; // get the coord to check if it exists

                        // This is for removing cell index from other color if it has been selected
                        Object.keys(colorCoordinates).forEach(key => {

                            // if the cor already exists
                            if (key !== `color${colorIndex}` && colorCoordinates[key].includes(coord)) {
                                const index = colorCoordinates[key].indexOf(coord);
                                if (index > -1) {
                                    colorCoordinates[key].splice(index, 1); // Remove the coordinate
                                    updateColorCoordinates(parseInt(key.replace('color', ''))); // Update HTML for removed coordinate
                                }
                            }
                        });
                        // Check if the coordinate is not already in the array before adding it to avoid dupes
                        if (!colorCoordinates[`color${colorIndex}`].includes(coord)) {
                            colorCoordinates[`color${colorIndex}`].push(coord);
                            updateColorCoordinates(colorIndex); // Update coordinates in the HTML
                        }
                        
                        console.log("coloring cell:", chosenColor); // console log for debugging
                    }
                });
            });

            document.getElementById('printableViewButton').addEventListener('click', function() {   
                const color_options = <?php echo json_encode($color_options); ?>;
                let hexCodes = [];
                color_options.forEach(code => {
                    hexCodes.push(code['hex']);
                });

                const rc = <?php echo json_encode($rc); ?>;
                const num_colors = <?php echo json_encode($num_colors); ?>;
                
                const params = new URLSearchParams({
                    rc, 
                    num_colors, 
                    selectedColors: JSON.stringify(selectedColors),
                    colorCoordinates: JSON.stringify(colorCoordinates),
                    hexCodes: JSON.stringify(hexCodes)
                }).toString();
                window.location.href = `content/printableView.php?${params}`;
            });
        });
    </script>
</main>
