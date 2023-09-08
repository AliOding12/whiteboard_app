const canvas = document.getElementById('whiteboard');
const ctx = canvas.getContext('2d');
let drawing = false;
let lastX, lastY;

// Drawing logic
canvas.addEventListener('mousedown', (e) => {
    drawing = true;
    [lastX, lastY] = [e.offsetX, e.offsetY];
});

canvas.addEventListener('mousemove', (e) => {
    if (!drawing) return;
    const [x, y] = [e.offsetX, e.offsetY];
    drawLine(lastX, lastY, x, y, '#000000', 2);
    sendDrawing(lastX, lastY, x, y, '#000000', 2);
    [lastX, lastY] = [x, y];
});

canvas.addEventListener('mouseup', () => drawing = false);
canvas.addEventListener('mouseout', () => drawing = false);

function drawLine(startX, startY, endX, endY, color, thickness) {
    ctx.beginPath();
    ctx.moveTo(startX, startY);
    ctx.lineTo(endX, endY);
    ctx.strokeStyle = color;
    ctx.lineWidth = thickness;
    ctx.stroke();
}

function sendDrawing(startX, startY, endX, endY, color, thickness) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_drawing.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({ startX, startY, endX, endY, color, thickness }));
}

// Polling for updates
function fetchDrawings() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'data/drawings.xml', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(xhr.responseText, 'text/xml');
            const lines = xmlDoc.getElementsByTagName('line');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (let line of lines) {
                const startX = parseFloat(line.getAttribute('start_x'));
                const startY = parseFloat(line.getAttribute('start_y'));
                const endX = parseFloat(line.getAttribute('end_x'));
                const endY = parseFloat(line.getAttribute('end_y'));
                const color = line.getAttribute('color');
                const thickness = parseFloat(line.getAttribute('thickness'));
                drawLine(startX, startY, endX, endY, color, thickness);
            }
        }
    };
    xhr.send();
}//i used xhr for learning purpose of this project but not necessary you can create yours with anything axios etc etc 

setInterval(fetchDrawings, 1000); // Poll every 1 second// Initialize whiteboard.js with basic canvas setup
// Add drawing functionality to whiteboard.js
// Implement XHR for sending drawing data to server
// Add support for loading drawings from XML
// Add undo/redo functionality to whiteboard.js
// Implement drawing tool selection in whiteboard.js
// Add real-time drawing sync via XHR
// Add support for multiple canvas layers
// Add color picker to whiteboard.js
// Add export drawing feature
// Optimize canvas rendering performance
// Add unit tests for whiteboard.js
// Initialize whiteboard.js with basic canvas setup
// Add drawing functionality to whiteboard.js
// Implement XHR for sending drawing data to server
// Add support for loading drawings from XML
// Add undo/redo functionality to whiteboard.js
// Implement drawing tool selection in whiteboard.js
// Add real-time drawing sync via XHR
// Add support for multiple canvas layers
