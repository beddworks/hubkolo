
    <style>
        .scanner-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .scan-options {
            display: flex;
            width: 100%;
            max-width: 500px;
            justify-content: space-between;
            margin-bottom: 20px;
        }


        .upload-btn {
            background-color: #3498db;
        }

        .upload-btn:hover {
            background-color: #2980b9;
        }

        .video-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            height: 375px !important;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            background-color: #000;
            display: block !important;
            z-index: 10;
        }

        #video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
            background-color: #000;
        }

        canvas.drawingBuffer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .scanner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 5;
        }

        .scanner-line {
            height: 2px;
            width: 80%;
            background: #ff5722;
            animation: scan 2s linear infinite;
            box-shadow: 0 0 8px rgba(255, 87, 34, 0.8);
        }

        .scan-instructions {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 8px;
            font-size: 14px;
            z-index: 10;
        }

        .image-preview {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #uploadedImage {
            width: 100%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        #scanImageButton {
            margin-top: 10px;
        }

        @keyframes scan {
            0% {
                transform: translateY(-100px);
            }
            50% {
                transform: translateY(100px);
            }
            100% {
                transform: translateY(-100px);
            }
        }

        .result-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        #result {
            margin-top: 10px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 4px;
            font-family: monospace;
            font-size: 18px;
            word-break: break-all;
        }

        .result-item {
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-item strong {
            color: #333;
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        .result-format {
            margin-top: 10px;
            color: #999;
            font-size: 12px;
            text-align: right;
        }

        .canvas-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
        }

        .loading-indicator {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 20;
        }

        .loading-indicator:after {
            content: '';
            display: block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 4px solid #fff;
            border-color: #fff transparent #fff transparent;
            animation: spin 1.2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
            
            .btn {
                padding: 10px 20px;
                font-size: 14px;
            }
            
            .scan-options {
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }
            
            .upload-container {
                width: 100%;
            }
            
            .upload-btn {
                display: block;
                width: 100%;
            }
        } 
    </style>
    <div class="modal-body">
        <div class="scanner-container">
            <div class="video-container" id="videoContainer">
                <video id="video" playsinline autoplay muted></video>
                <div class="scanner-overlay">
                    <div class="scanner-line"></div>
                </div>
                <div class="scan-instructions">Position barcode in the frame</div>
                <div class="loading-indicator" id="loadingIndicator"></div>
            </div>

            <div class="scan-options d-flex justify-content-center">
                <button id="scanButton" class="btn btn-primary btn-md">Start Camera Scanner</button>
                <div class="upload-container d-none">
                    <label for="imageUpload" class="btn upload-btn">Upload Image</label>
                    <input type="file" id="imageUpload" accept="image/*" style="display:none">
                </div>
            </div>
            
            <div class="image-preview" id="imagePreview" style="display:none">
                <img id="uploadedImage" src="" alt="Uploaded image">
                <button id="scanImageButton" class="btn">Scan This Image</button>
            </div>
        </div>

        <div class="result-container d-none">
            <h2>Scan Result:</h2>
            <div id="result">No barcode detected</div>
        </div>

         <!-- Camera troubleshooting section -->
        <div class="container" id="troubleshootSection" style="display:none; margin-top: 20px;">
            <div class="result-container">
                <h2>Camera Troubleshooting</h2>
                <p>If the camera is not showing, try these solutions:</p>
                <ol style="margin-left: 20px; line-height: 1.6;">
                    <li>Make sure you're using a secure connection (HTTPS or localhost)</li>
                    <li>Allow camera permissions when prompted by your browser</li>
                    <li>Try using Chrome or Firefox for best compatibility</li>
                    <li>On mobile, ensure you're not in battery saving mode</li>
                    <li>Check your browser console (F12) for specific error messages</li>
                </ol>
                <button id="tryAgainBtn" class="btn" style="margin-top: 15px;">Try Again</button>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    </div>

    <script src="{{ asset('packages/workdo/Pos/src/Resources/assets/js/quagga.min.js') }}"></script>
        
    <script>
            const scanButton = document.getElementById('scanButton');
            const resultElement = document.getElementById('result');
            const videoElement = document.getElementById('video');
            const videoContainer = document.getElementById('videoContainer');
            const imageUpload = document.getElementById('imageUpload');
            const imagePreview = document.getElementById('imagePreview');
            const uploadedImage = document.getElementById('uploadedImage');
            const scanImageButton = document.getElementById('scanImageButton');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const troubleshootSection = document.getElementById('troubleshootSection');
            const tryAgainBtn = document.getElementById('tryAgainBtn');
            
            let scanning = false;
            let cameraAccessAttempts = 0;
            const MAX_CAMERA_ATTEMPTS = 2;

            let addCartProductOnce = {
                sku: '',
                status: false
            }
            
            // Debug output for troubleshooting
            console.log('DOM loaded, initializing scanner app');
            console.log('Video element:', videoElement);
            console.log('Video container:', videoContainer);
            
            // Try again button
            if (tryAgainBtn) {
                tryAgainBtn.addEventListener('click', function() {
                    troubleshootSection.style.display = 'none';
                    cameraAccessAttempts = 0;
                    startScanner();
                });
            }
            
            // Check if the browser supports getUserMedia
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                console.error('getUserMedia API not supported in this browser');
                alert('Your browser does not support camera access through getUserMedia. Please try a modern browser like Chrome, Firefox, Safari, or Edge.');
                scanButton.disabled = true;
                resultElement.textContent = 'Camera API not supported on this browser';
                showTroubleshootSection();
            }
            
            // Handle file upload
            imageUpload.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const file = e.target.files[0];
                    
                    // Make sure it's an image
                    if (!file.type.match('image.*')) {
                        alert('Please select an image file');
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Stop scanner if it's running
                        if (scanning) {
                            stopScanner();
                            scanButton.textContent = 'Start Camera Scanner';
                            scanning = false;
                        }
                        
                        // Show image preview
                        uploadedImage.src = e.target.result;
                        videoContainer.style.display = 'none';
                        imagePreview.style.display = 'flex';
                        troubleshootSection.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            // Handle scan image button click
            scanImageButton.addEventListener('click', function() {
                scanStaticImage(uploadedImage);
            });
            
            // Scanner button for live video
            scanButton.addEventListener('click', function() {
                console.log('Scan button clicked, current state:', scanning);
                
                if (scanning) {
                    stopScanner();
                    scanButton.textContent = 'Start Camera Scanner';
                    scanning = false;
                } else {
                    // Hide image preview, show video
                    imagePreview.style.display = 'none';
                    videoContainer.style.display = 'block';
                    troubleshootSection.style.display = 'none';
                    
                    // Explicitly set video container dimensions
                    videoContainer.style.height = '375px';
                    videoElement.style.height = '100%';
                    videoElement.style.width = '100%';
                    videoElement.style.objectFit = 'cover';
                    
                    // Show loading indicator
                    loadingIndicator.style.display = 'block';
                    
                    // Reset camera attempts
                    cameraAccessAttempts = 0;
                    
                    startScanner();
                    scanButton.textContent = 'Stop Scanner';
                    scanning = true;
                }
            });
            
            // Function to show troubleshooting section
            function showTroubleshootSection() {
                if (troubleshootSection) {
                    troubleshootSection.style.display = 'block';
                    
                    if (scanning) {
                        stopScanner();
                        scanButton.textContent = 'Start Camera Scanner';
                        scanning = false;
                    }
                }
            }
            
            // Function to scan static images
            function scanStaticImage(imageElement) {
                // Display a loading indicator
                resultElement.textContent = 'Processing image...';
                
                Quagga.decodeSingle({
                    decoder: {
                        readers: [
                            "code_128_reader",
                            // "ean_reader",
                            // "ean_8_reader",
                            // "code_39_reader",
                            // "code_93_reader",
                            // "upc_reader",
                            // "upc_e_reader",
                            // "codabar_reader",
                            // "i2of5_reader"
                        ]
                    },
                    locate: true,
                    src: imageElement.src
                }, function(result) {
                    if (result && result.codeResult) {
                        const code = result.codeResult.code;
                        const format = result.codeResult.format;
                        
                        // console.log('Barcode detected in image:', code, 'Format:', format);
                        
                        // Parse barcode data to extract meaningful information
                        const parsedData = parseBarcode(code, format);
                        displayBarcodeInfo(parsedData);
                        
                        // Flash the result for visibility
                        resultElement.style.backgroundColor = "#4CAF50";
                        resultElement.style.color = "white";
                        
                        setTimeout(() => {
                            resultElement.style.backgroundColor = "#f9f9f9";
                            resultElement.style.color = "#333";
                        }, 500);
                        
                        // Draw box around the barcode on the image
                        drawBarcodeLocation(result, imageElement);
                    } else {
                        // console.log('No barcode detected in the image');
                        resultElement.textContent = 'No barcode detected in the image. Try a clearer image or different angle.';
                    }
                });
            }
            
            // Function to draw box around barcode in static image
            function drawBarcodeLocation(result, imageElement) {
                // Create a canvas overlay if it doesn't exist
                let canvasOverlay = document.querySelector('.canvas-overlay');
                if (!canvasOverlay) {
                    canvasOverlay = document.createElement('canvas');
                    canvasOverlay.className = 'canvas-overlay';
                    imagePreview.insertBefore(canvasOverlay, scanImageButton);
                    
                    // Set canvas size to match image
                    canvasOverlay.width = imageElement.width;
                    canvasOverlay.height = imageElement.height;
                    
                    // Position canvas over the image
                    canvasOverlay.style.position = 'absolute';
                    canvasOverlay.style.top = '0';
                    canvasOverlay.style.left = '0';
                }
                
                const ctx = canvasOverlay.getContext('2d');
                ctx.clearRect(0, 0, canvasOverlay.width, canvasOverlay.height);
                
                if (result.box) {
                    ctx.strokeStyle = '#00F';
                    ctx.lineWidth = 5;
                    
                    // Calculate scale factor
                    const scaleX = imageElement.width / imageElement.naturalWidth;
                    const scaleY = imageElement.height / imageElement.naturalHeight;
                    
                    ctx.strokeRect(
                        result.box.x * scaleX, 
                        result.box.y * scaleY,
                        result.box.width * scaleX, 
                        result.box.height * scaleY
                    );
                }
            }
            
            function startScanner() {
                console.log('Starting scanner, attempt #', cameraAccessAttempts + 1);
                resultElement.textContent = 'Accessing camera...';
                loadingIndicator.style.display = 'block';
                
                // Increment attempts counter
                cameraAccessAttempts++;
                
                // First check if we can access the camera directly
                navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: "environment",
                        width: { ideal: 1280 },
                        height: { ideal: 720 } 
                    },
                    audio: false
                })
                .then(function(stream) {
                    console.log('Camera access granted:', stream);
                    
                    // First show the camera directly so user sees something immediately
                    videoElement.srcObject = stream;
                    
                    // Set the onloadedmetadata event to know when the video is ready
                    videoElement.onloadedmetadata = function() {
                        console.log('Video metadata loaded');
                        videoElement.play()
                        .then(() => {
                            console.log('Video playing directly from getUserMedia');
                            loadingIndicator.style.display = 'none';
                            
                            // IMPORTANT CHANGE: Don't stop the stream before initializing Quagga
                            // Instead, pass the stream to Quagga to use
                            initQuagga(stream);
                        })
                        .catch(e => {
                            console.error('Error playing video directly:', e);
                            handleCameraError(e);
                        });
                    };
                    
                    // Set a timeout in case onloadedmetadata never fires
                    setTimeout(() => {
                        if (!videoElement.videoWidth) {
                            console.warn('Video metadata never loaded');
                            handleCameraError(new Error('Video metadata never loaded'));
                        }
                    }, 5000);
                })
                .catch(function(err) {
                    handleCameraError(err);
                });
            }
            
            // Handle camera errors with better feedback
            function handleCameraError(err) {
                console.error('Camera access error:', err);
                loadingIndicator.style.display = 'none';
                
                // Show error in result area
                resultElement.innerHTML = `Camera error: ${err.name || 'Unknown'}<br>Message: ${err.message || err}`;
                
                // Try alternate approach if we haven't exceeded max attempts
                if (cameraAccessAttempts < MAX_CAMERA_ATTEMPTS) {
                    console.log(`Trying alternate camera approach (attempt ${cameraAccessAttempts + 1})`);
                    
                    // Try with simpler constraints
                    navigator.mediaDevices.getUserMedia({ 
                        video: true,
                        audio: false
                    })
                    .then(stream => {
                        console.log('Camera access granted with simplified constraints');
                        videoElement.srcObject = stream;
                        videoElement.play()
                        .then(() => {
                            console.log('Video playing with simplified constraints');
                            loadingIndicator.style.display = 'none';
                            // Don't initialize Quagga here, just show the video
                        })
                        .catch(e => {
                            console.error('Error playing video with simplified constraints:', e);
                            showTroubleshootSection();
                        });
                    })
                    .catch(e => {
                        console.error('Camera access failed with simplified constraints:', e);
                        scanButton.textContent = 'Start Camera Scanner';
                        scanning = false;
                        showTroubleshootSection();
                    });
                } else {
                    scanButton.textContent = 'Start Camera Scanner';
                    scanning = false;
                    showTroubleshootSection();
                }
            }
            
            function initQuagga(existingStream) {
                console.log('Initializing Quagga...');
                
                // Add a direct video element check
                if (!videoElement) {
                    console.error('Video element not found!');
                    resultElement.textContent = 'Video element not found on page';
                    return;
                }
                
                // Keep the video element showing the existing stream while Quagga initializes
                // This prevents the black flash/disappearing video
                
                Quagga.init({
                    inputStream: {
                        name: "Live",
                        type: "LiveStream",
                        target: videoElement,
                        constraints: {
                            width: 1280,
                            height: 720,
                            facingMode: "environment", // Use the rear camera on mobile devices
                            // If we have an existing stream, try to use it
                            ...(existingStream ? { deviceId: existingStream.getVideoTracks()[0].getSettings().deviceId } : {})
                        },
                        area: { // Only look for codes in the center of the video
                            top: "25%",
                            right: "25%",
                            left: "25%",
                            bottom: "25%",
                        }
                    },
                    locator: {
                        patchSize: "medium",
                        halfSample: true
                    },
                    numOfWorkers: navigator.hardwareConcurrency || 4,
                    frequency: 10, // Increase this value for better performance on slower devices
                    decoder: {
                        readers: [
                            "code_128_reader",
                            // "ean_reader",
                            // "ean_8_reader",
                            // "code_39_reader",
                            // "code_93_reader",
                            // "upc_reader",
                            // "upc_e_reader",
                            // "codabar_reader",
                            // "i2of5_reader"
                        ]
                    },
                    locate: true
                }, function(err) {
                    if (err) {
                        console.error('Quagga initialization error:', err);
                        
                        // Keep the existing video stream running if Quagga fails
                        if (existingStream) {
                            console.log('Keeping existing camera stream active since Quagga failed');
                            loadingIndicator.style.display = 'none';
                            resultElement.textContent = 'Using basic camera mode (barcode detection unavailable)';
                            return;
                        }
                        
                        alert('Error initializing scanner: ' + (err.message || err));
                        scanButton.textContent = 'Start Camera Scanner';
                        scanning = false;
                        resultElement.innerHTML = `Scanner error: ${err.name || 'Unknown'}<br>Message: ${err.message || err}`;
                        
                        // Hide loading indicator
                        loadingIndicator.style.display = 'none';
                        
                        // Show troubleshooting section
                        showTroubleshootSection();
                        return;
                    }
                    
                    console.log('Scanner initialized successfully');
                    resultElement.textContent = 'Scanner ready. Point camera at a barcode.';
                    
                    // Hide loading indicator
                    loadingIndicator.style.display = 'none';
                    
                    Quagga.start();
                    
                    // Check if video is actually playing
                    setTimeout(() => {
                        if (videoElement.videoWidth === 0 || videoElement.videoHeight === 0) {
                            console.warn('Video dimensions are zero after Quagga started, video may not be playing');
                            
                            // If we still have an existing stream, just keep using it
                            if (existingStream && existingStream.active) {
                                console.log('Keeping existing stream active');
                                return;
                            }
                            
                            // Otherwise try direct method as a fallback
                            navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                            .then(stream => {
                                videoElement.srcObject = stream;
                                videoElement.play();
                                console.log('Fallback video method applied');
                            })
                            .catch(err => {
                                console.error('Fallback camera method failed:', err);
                                showTroubleshootSection();
                            });
                        } else {
                            console.log('Video is playing, dimensions:', videoElement.videoWidth, 'x', videoElement.videoHeight);
                        }
                    }, 1000);
                });
                
                Quagga.onDetected(handleBarcodeDetected);
                Quagga.onProcessed(handleProcessed);
            }
            
            function stopScanner() {
                console.log('Stopping scanner...');
                
                // Hide loading indicator
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }
                
                // First try to stop Quagga if it's running
                if (Quagga) {
                    try {
                        Quagga.offDetected(handleBarcodeDetected);
                        Quagga.offProcessed(handleProcessed);
                        Quagga.stop();
                        console.log('Quagga stopped successfully');
                    } catch (e) {
                        console.error('Error stopping Quagga:', e);
                    }
                }
                
                // Then stop any direct video stream
                if (videoElement && videoElement.srcObject) {
                    try {
                        const tracks = videoElement.srcObject.getTracks();
                        console.log('Stopping video tracks:', tracks.length);
                        tracks.forEach(track => {
                            track.stop();
                            console.log('Track stopped:', track.kind);
                        });
                        videoElement.srcObject = null;
                        console.log('Video stream cleared');
                    } catch (e) {
                        console.error('Error stopping video stream:', e);
                    }
                }
            }
            
            function handleBarcodeDetected(result) {
                if (result && result.codeResult) {
                    const code = result.codeResult.code;
                    const format = result.codeResult.format;
                    
                    // console.log('Barcode detected:', code, 'Format:', format);
                    
                    // Parse barcode data to extract meaningful information
                    const parsedData = parseBarcode(code, format);
                    displayBarcodeInfo(parsedData);
                    
                    // Create a beep sound
                    const beep = new Audio("data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YU");
                    beep.play().catch(e => console.log('Error playing beep:', e));
                    
                    // Flash the result for visibility
                    resultElement.style.backgroundColor = "#4CAF50";
                    resultElement.style.color = "white";
                    
                    setTimeout(() => {
                        resultElement.style.backgroundColor = "#f9f9f9";
                        resultElement.style.color = "#333";
                    }, 500);
                }
            }
            
            function handleProcessed(result) {
                // Visualize the scanning process in the viewport
                const drawingCanvas = document.querySelector('canvas.drawingBuffer');
                if (drawingCanvas) {
                    const drawingContext = drawingCanvas.getContext('2d');
                    
                    if (result) {
                        if (result.boxes) {
                            drawingContext.clearRect(0, 0, drawingCanvas.width, drawingCanvas.height);
                            
                            result.boxes.filter(box => box !== result.box).forEach(box => {
                                drawingContext.strokeStyle = 'red';
                                drawingContext.lineWidth = 2;
                                drawingContext.strokeRect(
                                    box[0], box[1],
                                    box[2] - box[0],
                                    box[3] - box[1]
                                );
                            });
                        }
                        
                        if (result.box) {
                            drawingContext.strokeStyle = '#00F';
                            drawingContext.lineWidth = 2;
                            drawingContext.strokeRect(
                                result.box.x, result.box.y,
                                result.box.width, result.box.height
                            );
                        }
                        
                        if (result.codeResult && result.codeResult.code) {
                            drawingContext.font = '24px Arial';
                            drawingContext.fillStyle = 'green';
                            drawingContext.fillText(result.codeResult.code, 10, 20);
                        }
                    }
                }
            }
            
            /**
             * Parse barcode data based on format to extract meaningful information
             * @param {string} code - The raw barcode data
             * @param {string} format - The barcode format (e.g., 'ean_13', 'code_128')
             * @returns {object} An object containing parsed information
             */
            function parseBarcode(code, format) {

                console.log('Parsing barcode:', code, 'Format:', format);
                // Initialize result object with raw data
                const result = {
                    raw: code,
                    format: format,
                    type: 'unknown',
                    info: {}
                };
                
                // Normalize format name for easier processing
                const formatLower = format.toLowerCase();
                
                // Parse based on barcode format
                if (formatLower.includes('ean_13') || formatLower.includes('ean13') || formatLower.includes('upc')) {
                    // Handle EAN-13/UPC format (common for retail products)
                    result.type = 'product';
                    
                    // Extract country/manufacturer code (first digits)
                    if (code.length === 13) {
                        result.info.countryCode = code.substring(0, 3);
                        result.info.manufacturerCode = code.substring(3, 7);
                        result.info.productCode = code.substring(7, 12);
                        result.info.checkDigit = code.substring(12);
                        
                        // Try to identify if this is a special GS1 prefix
                        if (code.startsWith('978') || code.startsWith('979')) {
                            result.type = 'isbn';
                            result.info.isbnPrefix = code.substring(0, 3);
                            result.info.groupIdentifier = code.substring(3, 5);
                            result.info.publisherCode = code.substring(5, 9);
                            result.info.itemNumber = code.substring(9, 12);
                        }
                    } else if (code.length === 12) {
                        // UPC-A
                        result.info.manufacturerCode = code.substring(0, 6);
                        result.info.productCode = code.substring(6, 11);
                        result.info.checkDigit = code.substring(11);
                    }
                    
                    // Add SKU-like identifier
                    result.info.sku = `SKU-${code}`;
                    
                } else if (formatLower.includes('ean_8') || formatLower.includes('ean8')) {
                    // Handle EAN-8 format
                    result.type = 'product';
                    if (code.length === 8) {
                        result.info.countryCode = code.substring(0, 3);
                        result.info.productCode = code.substring(3, 7);
                        result.info.checkDigit = code.substring(7);
                        result.info.sku = `SKU-${code}`;
                    }
                    
                } else if (formatLower.includes('code_128') || formatLower.includes('code128')) {
                    // Attempt to parse Code 128 - could be anything
                    // Check if it matches common patterns
                    
                    // Check if it looks like a SKU (alphanumeric with dashes, etc.)
                    if (/^[A-Z0-9\-\_]{5,20}$/i.test(code)) {
                        result.type = 'sku';
                        result.info.sku = code;
                    }
                    
                    // Check if it might be a serial number
                    if (/^[A-Z]{1,4}[0-9]{4,12}$/i.test(code)) {
                        result.type = 'serial';
                        result.info.serialNumber = code;
                    }
                    
                    // Check for URL
                    if (code.startsWith('http')) {
                        result.type = 'url';
                        result.info.url = code;
                    }
                    
                    // Fall back to generic identifier
                    if (result.type === 'unknown') {
                        result.info.id = code;
                    }
                    
                } else if (formatLower.includes('code_39') || formatLower.includes('code39')) {
                    // Code 39 often used for internal tracking, IDs, etc.
                    result.type = 'identifier';
                    
                    // Extract possible product ID / SKU
                    result.info.id = code;
                    
                    // If it includes letters and numbers, it's likely a SKU
                    if (/[A-Z]/.test(code) && /[0-9]/.test(code)) {
                        result.info.sku = code;
                    }
                    
                } else if (formatLower.includes('qr')) {
                    // QR codes can contain various data formats
                    
                    // Check if it's a URL
                    if (code.startsWith('http')) {
                        result.type = 'url';
                        result.info.url = code;
                    } 
                    // Check if it's contact info (vCard)
                    else if (code.startsWith('BEGIN:VCARD')) {
                        result.type = 'contact';
                        // Basic parsing of vCard
                        const name = code.match(/FN:(.*?)(?:\r\n|\n)/);
                        const email = code.match(/EMAIL:(.*?)(?:\r\n|\n)/);
                        if (name) result.info.name = name[1];
                        if (email) result.info.email = email[1];
                    }
                    // Check if it might be JSON
                    else if (code.startsWith('{') && code.endsWith('}')) {
                        try {
                            const jsonData = JSON.parse(code);
                            result.type = 'json';
                            result.info = { ...result.info, ...jsonData };
                        } catch (e) {
                            // Not valid JSON
                        }
                    }
                    // Otherwise treat as text
                    else {
                        result.type = 'text';
                        result.info.text = code;
                    }
                }
                
                // If we couldn't identify it but it has patterns like SKU
                if (result.type === 'unknown') {
                    // Check if it matches SKU patterns
                    if (code.includes('-') && /[A-Z0-9]/.test(code)) {
                        result.type = 'possible_sku';
                        result.info.possibleSku = code;
                    }
                    
                    // Check if it might be a product ID 
                    // (common pattern is alpha prefix followed by numbers)
                    if (/^[A-Z]{1,4}[0-9]{4,10}$/i.test(code)) {
                        result.type = 'product_id';
                        result.info.productId = code;
                    }
                    
                    // Always include the raw code as ID
                    result.info.id = code;
                }
                
                return result;
            }

            function playSound(sound){
                const audio = new Audio(sound);
                audio.play();
            }
            
            /**
             * Display parsed barcode information in the result element
             * @param {object} data - The parsed barcode data
             */
            function displayBarcodeInfo(data) {
                console.log('Parsed barcode data:', data);

                let url = '{{ route("addTocart", [":product_id", ":session", ":warehouse_id", ":sku"])}}';

                let sum = 0;

                const product = data.info.sku;

                if(addCartProductOnce.sku == product){
                    addCartProductOnce.status = true;
                }else{
                    addCartProductOnce.status = false;
                }

                url = url.replace(':product_id', 'undefined').replace(':session', 'pos').replace(':warehouse_id', 'undefined').replace(':sku', product);

                addCartProductOnce.sku = product;

                
                
                if (addCartProductOnce.sku == product && addCartProductOnce.status == false) {

                    $.ajax({
                        url: url,

                        success: function(data) {


                            if (data.code == '200') {

                                $('#displaytotal').text(addCommas(data.product.subtotal));
                                $('.totalamount').text(addCommas(data.product.subtotal));
                                if ('carttotal' in data) {
                                    $.each(data.carttotal, function(key, value) {
                                        $('#product-id-' + value.id + ' .subtotal').text(
                                            addCommas(value.subtotal));
                                        sum += value.subtotal;
                                    });
                                    $('#displaytotal').text(addCommas(sum));
                                    $('.totalamount').text(addCommas(sum));

                                    $('.discount').val('');
                                }

                                $('#tbody').append(data.carthtml);
                                $('.no-found').addClass('d-none');
                                $('.carttable #product-id-' + data.product.id +
                                    ' input[name="quantity"]').val(data.product.quantity);
                                $('#btn-pur button').removeAttr('disabled');
                                $('#btn-pur .btn-empty a').removeAttr('style');
                                $('.btn-empty button').addClass('btn-clear-cart');

                                addCartProductOnce.status = true;

                                playSound("{{ asset('packages/workdo/Pos/src/Resources/assets/scanner-beep.mp3') }}");

                                show_toastr('{{ __('Success') }}', 'Product added to cart', 'success');
                            }

                        },
                        error: function(data) {
                            data = data.responseJSON;
                            console.log('ini error', data);
                            show_toastr('{{ __('Error') }}', data.message, 'error');
                        }
                    });

                }
                

                
                // Create result display based on the type of barcode
                let displayHTML = '';
                
                switch(data.type) {
                    case 'product':
                        displayHTML = `
                            <div class="result-item">
                                <strong>Product Code:</strong> ${data.info}
                            </div>
                        `;
                        
                        if (data.info.sku) {
                            displayHTML += `
                                <div class="result-item">
                                    <strong>SKU:</strong> ${data.info.sku}
                                </div>
                            `;
                        }
                        
                        if (data.info.manufacturerCode) {
                            displayHTML += `
                                <div class="result-item">
                                    <strong>Manufacturer:</strong> ${data.info.manufacturerCode}
                                </div>
                            `;
                        }
                        break;
                        
                    case 'isbn':
                        displayHTML = `
                            <div class="result-item">
                                <strong>ISBN:</strong> ${data.raw}
                            </div>
                        `;
                        break;
                        
                    case 'sku':
                        displayHTML = `
                            <div class="result-item">
                                <strong>SKU:</strong> ${data.info.sku}
                            </div>
                        `;
                        break;
                        
                    case 'serial':
                        displayHTML = `
                            <div class="result-item">
                                <strong>Serial Number:</strong> ${data.info.serialNumber}
                            </div>
                        `;
                        break;
                        
                    case 'url':
                        displayHTML = `
                            <div class="result-item">
                                <strong>URL:</strong> ${data.info.url}
                            </div>
                        `;
                        break;
                        
                    case 'identifier':
                    case 'product_id':
                        displayHTML = `
                            <div class="result-item">
                                <strong>ID:</strong> ${data.info.id}
                            </div>
                        `;
                        if (data.info.sku) {
                            displayHTML += `
                                <div class="result-item">
                                    <strong>SKU:</strong> ${data.info.sku}
                                </div>
                            `;
                        }
                        break;
                        
                    default:
                        // For unknown types, just show the raw value
                        displayHTML = `
                            <div class="result-item">
                                <strong>Value:</strong> ${data.raw}
                            </div>
                        `;
                }
                
                // Add format information at the bottom
                displayHTML += `
                    <div class="result-format">
                        <small>Format: ${data.format}</small>
                    </div>
                `;
                
                // Update the result element with the HTML
                resultElement.innerHTML = displayHTML;
            }
            
            // Handle page visibility changes
            document.addEventListener('visibilitychange', function() {
                if (document.hidden && scanning) {
                    stopScanner();
                } else if (!document.hidden && scanning) {
                    startScanner();
                }
            });
            
            // Cleanup on page unload
            window.addEventListener('beforeunload', function() {
                if (scanning) {
                    stopScanner();
                }
            });
    </script>
