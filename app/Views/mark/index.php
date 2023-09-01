<h1>Anatomy Marking Tool</h1>
    <div style="position: relative;">
        <img src="<?= base_url('/assets/upload/image/anatomi/telinga.jpg'); ?>" alt="Anatomy Image" id="anatomyImage">
        <canvas id="markCanvas" style="position: absolute; top: 0; left: 0;"></canvas>
    </div>
    <div>
        <label for="shapeSelect">Select Shape:</label>
        <select id="shapeSelect">
            <option value="box">Box</option>
            <option value="circle">Circle</option>
            <option value="triangle">Triangle</option>
        </select>
    </div>
    <div>
        <label for="notes">Notes:</label>
        <textarea id="notes"></textarea>
    </div>
    <button id="saveMarkButton">Save Mark</button>

    <script>
        const anatomyImage = document.getElementById('anatomyImage');
        const markCanvas = document.getElementById('markCanvas');
        const shapeSelect = document.getElementById('shapeSelect');
        const notesInput = document.getElementById('notes');
        const saveMarkButton = document.getElementById('saveMarkButton');
        const ctx = markCanvas.getContext('2d');

        // Set canvas size to match image size
        markCanvas.width = anatomyImage.width;
        markCanvas.height = anatomyImage.height;

        // Variables to store marked points and related data
        let markedPoints = [];

        // Function to draw marks on canvas
        function drawMark(x, y, shape) {
            ctx.beginPath();
            if (shape === 'box') {
                ctx.rect(x - 10, y - 10, 20, 20);
            } else if (shape === 'circle') {
                ctx.arc(x, y, 10, 0, 2 * Math.PI);
            } else if (shape === 'triangle') {
                ctx.moveTo(x, y - 10);
                ctx.lineTo(x + 10, y + 10);
                ctx.lineTo(x - 10, y + 10);
                ctx.closePath();
            }
            ctx.stroke();
        }

        // Event listener to handle marking
        anatomyImage.addEventListener('click', (event) => {
            const x = event.offsetX;
            const y = event.offsetY;
            const selectedShape = shapeSelect.value;
            markedPoints.push({ x, y, shape: selectedShape, notes: notesInput.value });

            // Clear and redraw canvas
            ctx.clearRect(0, 0, markCanvas.width, markCanvas.height);
            markedPoints.forEach((point) => {
                drawMark(point.x, point.y, point.shape);
            });
        });

        // Event listener to save marked points
        saveMarkButton.addEventListener('click', () => {
            // Send data to server using AJAX or fetch
            // Replace with your server endpoint and data structure
            fetch('<?= site_url('/admin/mark/saveMark'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(markedPoints),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Clear canvas and markedPoints array
                    ctx.clearRect(0, 0, markCanvas.width, markCanvas.height);
                    markedPoints = [];
                } else {
                    alert('Failed to save mark.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the mark.');
            });
        });
    </script>