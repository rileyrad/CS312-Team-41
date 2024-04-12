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
                echo "<td width='80%'><select class='colorSelectors' name='color$i'>";
                foreach ($color_options as $option) {
                    if ($option == $color_options[$i]) {
                        echo "<option value='$option' selected='true'>$option</option>";
                    } else {
                        echo "<option value='$option'>$option</option>";
                    }
                }
                echo "</select></td>";
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

            selectors.forEach((selector, index) => {
                const color = selector.value;
                selectedColors[`color${index}`] = selector.value;
                selector.setAttribute('data-prev', selector.value);

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
                    }
                });
            });

            document.getElementById('printableViewButton').addEventListener('click', function() {
                const rc = <?php echo json_encode($rc); ?>;
                const colors = <?php echo json_encode($colors); ?>;
                const params = new URLSearchParams({
                    rc, 
                    colors, 
                    selectedColors: JSON.stringify(selectedColors)
                }).toString();
                window.location.href = `content/printableView.php?${params}`;
            });
        });
    </script>
</main>
