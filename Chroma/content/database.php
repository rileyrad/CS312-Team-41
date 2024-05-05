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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
