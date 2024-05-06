<body>
    <h1>Color Selection</h1>
    
    <div id="addColorForm">
        <h2>Add Color</h2>
        <form id="addColor">
            <label for="colorName">Name:</label>
            <input type="text" id="colorName" name="colorName">
            <label for="colorHex">Hex Value:</label>
            <input type="text" id="colorHex" name="colorHex">
            <button type="submit">Add Color</button>
            <p id="addError" class="error"></p>
        </form>
    </div>

    <div id="modifyColorForm">
        <h2>Modify Color</h2>
        <form id="modifyColor">
            <label for="modifyColorSelect">Select Color:</label>
            <select id="modifyColorSelect" name="modifyColorSelect">

            </select>
            <label for="modifyColorName">New Name:</label>
            <input type="text" id="modifyColorName" name="modifyColorName">
            <label for="modifyColorHex">New Hex Value:</label>
            <input type="text" id="modifyColorHex" name="modifyColorHex">
            <button type="submit">Modify Color</button>
            <p id="modifyError" class="error"></p>
        </form>
    </div>

    <div id="deleteColorForm">
        <h2>Delete Color</h2>
        <form id="deleteColor">
            <label for="deleteColorSelect">Select Color:</label>
            <select id="deleteColorSelect" name="deleteColorSelect">
               
            </select>
            <button type="submit">Delete Color</button>
            <p id="deleteError" class="error"></p>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="content/database.js"></script>
</body>
