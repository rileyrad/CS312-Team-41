CREATE TABLE IF NOT EXISTS colors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    hex VARCHAR(7) NOT NULL
);

INSERT IGNORE INTO colors (name, hex) 
SELECT name, hex FROM (
    SELECT 'red' as name, '#FF0000' as hex
    UNION SELECT 'orange', '#FFA500'
    UNION SELECT 'yellow', '#FFFF00'
    UNION SELECT 'green', '#008000'
    UNION SELECT 'blue', '#0000FF'
    UNION SELECT 'purple', '#800080'
    UNION SELECT 'grey', '#808080'
    UNION SELECT 'brown', '#A52A2A'
    UNION SELECT 'black', '#000000'
    UNION SELECT 'teal', '#008080'
) AS color_options
WHERE NOT EXISTS (
    SELECT 1 FROM colors WHERE colors.name = color_options.name AND colors.hex = color_options.hex
);