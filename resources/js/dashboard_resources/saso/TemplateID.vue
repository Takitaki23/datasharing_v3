<template>
    <div class="main-container" style="height: 650px; overflow: scroll;">
        <div class="dashboard_header" style="width: 80%; margin: auto;">
            <h1 class="fw-bold">Template ID</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Template ID
                    </li>
                </ol>
            </nav>
        </div>
        <div class="upload_files">
                <div class="upload-container">
                    <label for="formFile" class="form-label">Upload ID Template</label>
                    <input class="form-control short-input" type="file" id="formFile" multiple @change="handleFileUpload">
                </div>
                <div class="uploaded_files" v-if="uploadedFiles.length > 0" style="width:70%; margin: auto; margin-top: 1rem;">
                    <div class="uploaded_file" v-for="(file, index) in uploadedFiles" :key="index">
                        <img :src="file.url" :alt="'Uploaded ID Template ' + (index + 1)">
                    </div>
                </div>
        </div>
     
        <div class="scroll-container">
            <div
            class="row justify-content-center table-main"
            style="width: 90%; margin-left: 15%;
            "
           
            >
            <div class="col-md-12">
                <!-- {{ imageTemplates }} -->
                <div class="image-gallery">
                    <div
                        class="image-item"
                        v-for="(tmpID, index) in imageTemplates"
                        :key="index"
                    >
                        <img :src="'id_template/' + tmpID" alt="Image 1" @click="handleImageClick('id_template/' + tmpID)"/>
                        <div class="image-overlay">
                            <!-- Add any overlay content here -->
                        </div>
                    </div>

                    <!-- editor for template -->
                </div>

                <div class="row mt-3">
                    <h3 class="text-success">Edit Template</h3>
                    <!-- <div class="col-md-4 border">
                        <canvas
                            v-for="(content, index) in contents"
                            :key="index"
                            class="draggable"
                            :id="'canvas-' + index"
                            ref="draggableCanvases"
                        ></canvas>
                    </div> -->
                    <div class="col-md-6" style="height: 380px; overflow: hidden;">
                        <canvas
                            class=""
                            ref="canvasRef"
                            :width="canvasWidth"
                            :height="canvasHeight"
                        ></canvas>
                    </div>
                    
                    <div class="col-md-6" style="height: 380px;overflow: hidden;">
                        <canvas class="" ref="canvasBackRef" :width="canvasWidth" :height="canvasHeight"></canvas>
                    </div>

                </div>
            </div>
        </div>
        </div>
       

        <button
            type="button"
            class="btn btn-success mt-3 fw-bold generate-id-button"
            data-bs-toggle="modal"
            data-bs-target="#bulkPreviewModal"
            @click="handleExportButtonClick"
        >
            <i class="fa-solid fa-id-card-clip fa-flip fa-xl"></i> Save Template
            <!-- <span v-show="selectedIds != 0" class="badge text-bg-danger">
                {{ selectedIds }}</span
            > -->
        </button>
    </div>
    <!-- view modal -->
    <!-- <viewModal v-show="modalVisible" :modalData="modalData" :dataId="dataId"  @close="closeModalView" />
    <editModal v-show="editModalVisible" @close="closeModalEdit" />
    <addModal v-show="addModalVisible" :modalData="modalData" :dataId="dataId" :addModalVisible="addModalVisible" @close="closeModalAdd" />
    <previewId v-id="previewModalVisible" :modalData="modalData" :dataId="dataId" @close="closeModalPreview" /> -->
</template>
<script>
import { ref, onMounted, onUnmounted, watch, computed,getCurrentInstance, } from "vue";
import axios from "axios";
import interact from "interactjs";
import { useToast } from "vue-toast-notification";
// for debuging
// import collegef from "../../images/collegef.png";
// import collegeb from "../../images/collegeb.png";
import profile from "../../images/man.png";
// import signature from "../../images/man.png";
export default {

// For adding new template
    data() {
    return {
      uploadedFiles: [],
    };
  },
  methods: {
    handleFileUpload(event) {
      const files = event.target.files;
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const fileObject = {
          url: URL.createObjectURL(file),
          name: file.name,
        };
        // Insert the new file at the beginning of the array
        this.uploadedFiles.unshift(fileObject);
      }
    },
  },
    setup() {
        
        
        // const tmpID = ref("/id_template/collegef.png");
        // storage for templates
        const imageTemplates = ref([]);
        const templateCoordinates = ref([]);

        // college front
        let collegef = ref('/id_template/collegef.png')
        let collegeb = ref('/id_template/collegeb.png')

        let signature = ref('/id_signatures/1685325544.png')

        // Create a hidden canvas for double buffering
        const hiddenCanvas = document.createElement("canvas");
        // const hiddenContext = hiddenCanvas.getContext("2d");

        const hiddenCanvasBack = document.createElement("canvas");
        // const hiddenContextBack = hiddenCanvasBack.getContext("2d");

        // Add a selectedContentIndex reactive variable
        const selectedContentIndex = ref(null);
        const selectedContentIndexBack = ref(null);

        // const instance = getCurrentInstance();
        const canvasRef = ref(null);
        const canvasBackRef = ref(null);
        const canvasWidth = ref(0);
        const canvasHeight = ref(0);
        // we devided by 2 to make it smaller
        const profileX = ref(55 / 2); // Adjust the X coordinate as needed
        const profileY = ref(87 / 2); // Adjust the Y coordinate as needed
        const profileWidth = ref(352 / 2); // Adjust the width as needed
        const profileHeight = ref(415 / 2); // Adjust the height as needed
        // we devided by 2 to make it smaller
        const signatureX = ref((240+64.02) ); // Adjust the X coordinate as needed
        const signatureY = ref(75); // Adjust the Y coordinate as needed
        const signatureWidth = ref(300/2); // Adjust the width as needed
        const signatureHeight = ref(150); // Adjust the height as needed

        // Drag variables
        var isDragging = ref(false);
        var startX = ref(0);
        var startY = ref(0);
        var isDraggingBack = ref(false);
        var startXBack = ref(0);
        var startYBack = ref(0);
        const draggedElement = ref(null);
        const draggedElementBack = ref(null);

        // watch(statePath, () => {
        //     console.log(statePath);
        //     redrawCanvas();
        // });

        // for front contents
        const textContents = computed(() => {
            // Retrieve the template coordinates from the reactive value
            // const resolvedCoordinates = templateCoordinates.value;
            // console.log(templateCoordinates.value[0].profile_x)
            // console.log(responseData.value.student_no);
            const st_id_s = "20-1234";
            const course_s = "BS. INFORMATION TECHNOLOGY";
            const last_name = "Eastwoods";
            const first_name = "Professional";
            const middle_name = "SATech.";
            // we devided by 2 to make it smaller
            // Map the template coordinates to textContent objects
            return [
                { content: st_id_s, x: (templateCoordinates.value[0]?.textContents_0_x || 280) / 2, y: (templateCoordinates.value[0]?.textContents_0_y || 550) / 2, fontSize: 35 / 2 },
                { content: course_s, x: (templateCoordinates.value[0]?.textContents_1_x || 45) / 2, y: (templateCoordinates.value[0]?.textContents_1_y || 590) / 2, fontSize: 25 / 2 },
                { content: last_name, x: (templateCoordinates.value[0]?.textContents_2_x || 430) / 2, y: (templateCoordinates.value[0]?.textContents_2_y || 370) / 2, fontSize: 45 / 2 },
                { content: first_name, x: (templateCoordinates.value[0]?.textContents_3_x || 430) / 2, y: (templateCoordinates.value[0]?.textContents_3_y || 420) / 2, fontSize: 45 / 2 },
                { content: middle_name, x: (templateCoordinates.value[0]?.textContents_4_x || 430) / 2, y: (templateCoordinates.value[0]?.textContents_4_y || 470) / 2, fontSize: 45 / 2 },
                ];

        });

        // for back contents
        const textContentsBack = computed(()=>{
            const ecp = "CONTACT PERSON";
            const address1 = "#354 QUEZON ST. SAN JOSE BALANGA"
            // const barangay = "SAN JOSE"
            // const address2 = "BALANGA BATAAN"
            // const province = "BATAAN"
            const ecpc = "09345678986"
            const semester = "2nd Semester AY 2023 - 2024"
            return [
                {content: ecp, x:(templateCoordinates.value[0]?.textContentsBack_0_x || 310), y:(templateCoordinates.value[0]?.textContentsBack_0_y || 120) / 2,fontSize:30/2},
                {content: address1, x:(templateCoordinates.value[0]?.textContentsBack_1_x || 280),y:(templateCoordinates.value[0]?.textContentsBack_1_y ||160)/2,fontSize:22/2},
                // {content: barangay, x:255,y:0,fontSize:25},
                // {content: address2, x:255,y:122,fontSize:25/2},
                // {content: province, x:0,y:0,fontSize:0},
                {content: ecpc, x:(templateCoordinates.value[0]?.textContentsBack_2_x ||340),y:(templateCoordinates.value[0]?.textContentsBack_2_y ||200)/2,fontSize:25/2},
                {content: semester, x:(templateCoordinates.value[0]?.textContentsBack_3_x ||35),y:(templateCoordinates.value[0]?.textContentsBack_3_y || 500)/2,fontSize:30/2},
            ]
        })

        const updateCanvasSize = () => {
            const canvas = canvasRef.value;
            const canvasBack = canvasBackRef.value;
            if (canvas && canvasBack) {
                // we devided by 2 to make it smaller
                canvasWidth.value = canvas.width / 2;
                canvasHeight.value = canvas.height / 2;
            }
        };

        const redrawCanvas = () => {
            const canvas = canvasRef.value;
            const canvasBack = canvasBackRef.value;
            try {
                if (canvas && canvasBack) {
                const context = canvas.getContext("2d");
                const contextBack = canvasBack.getContext("2d");
                // we devided by 2 to make it smaller
                const canvasWidth = canvas.width / 2;
                const canvasHeight = canvas.height / 2;
                // front
                const offscreenCanvas = document.createElement("canvas");
                const offscreenContext = offscreenCanvas.getContext("2d");

                // back
                const offscreenCanvasBack = document.createElement("canvas");
                const offscreenContextBack = offscreenCanvas.getContext("2d");
                // Set offscreen canvas size
                offscreenCanvas.width = canvasWidth;
                offscreenCanvas.height = canvasHeight;
                    // second canvas
                offscreenCanvasBack.width = canvasWidth;
                offscreenCanvasBack.height = canvasHeight;

                // Clear the offscreen canvas1
                offscreenContext.clearRect(0, 0, canvasWidth, canvasHeight);
                // Clear the offscreen canvas2
                offscreenContextBack.clearRect(0, 0, canvasWidth, canvasHeight);

                // Draw the template image
                const templateImage = new Image();
                // draw the back
                const backTemplateImage = new Image();

                templateImage.src = collegef.value;
                templateImage.onload = () => {
                    const templateAspectRatio =
                        templateImage.width / templateImage.height;
                    const canvasAspectRatio = canvasWidth / canvasHeight;

                    let drawWidth, drawHeight;
                    let offsetX = 0,
                        offsetY = 0;

                    if (templateAspectRatio > canvasAspectRatio) {
                        console.log('greater than on canvas')
                        // Template image is wider than the canvas
                        drawWidth = canvasWidth;
                        drawHeight = drawWidth / templateAspectRatio;
                        offsetY = (canvasHeight - drawHeight) / 2;
                    } else {
                        // console.log('not greater than on canvas')
                        // Template image is taller than the canvas
                        drawHeight = canvasHeight;
                        drawWidth = drawHeight * templateAspectRatio;
                        offsetX = (canvasWidth - drawWidth) / 2;
                    }

                    // Draw the front template image on the offscreen canvas
                    offscreenContext.drawImage(
                        templateImage,
                        offsetX,
                        offsetY,
                        drawWidth,
                        drawHeight
                    );

                    // Draw the profile image
                    const profileImage = new Image();
                    profileImage.src = profile;
                    profileImage.onload = () => {
                        offscreenContext.drawImage(
                            profileImage,
                            profileX.value,
                            profileY.value,
                            profileWidth.value,
                            profileHeight.value
                        );

                        // Draw the text elements
                        if (textContents.value) {
                            textContents.value.forEach((textContent, index) => {
                                offscreenContext.font = `${textContent.fontSize}px Arial`;
                                context.fillStyle =
                                index === selectedContentIndex.value ? "red" : "black"; // Apply selection style
                                offscreenContext.fillText(
                                textContent.content,
                                textContent.x,
                                textContent.y
                                );
                            });
                        }

                        // Copy the offscreen canvas to the visible canvas
                        context.clearRect(0, 0, canvasWidth, canvasHeight);
                        context.drawImage(offscreenCanvas, 0, 0);

                        backTemplateImage.src = collegeb.value

                        backTemplateImage.onload = () => {
                            const backTemplateAspectRatio = backTemplateImage.width / backTemplateImage.height;
                            const canvasAspectRatio = canvasWidth / canvasHeight;

                            let backDrawWidth, backDrawHeight;
                            let backOffsetX = 0, backOffsetY = 0;

                            if (backTemplateAspectRatio > canvasAspectRatio) {
                                // Back template image is wider than the canvas
                                backDrawWidth = canvasWidth;
                                backDrawHeight = backDrawWidth / backTemplateAspectRatio;
                                backOffsetY = (canvasHeight - backDrawHeight) / 2;
                            } else {
                                // Back template image is taller than the canvas
                                backDrawHeight = canvasHeight;
                                backDrawWidth = backDrawHeight * backTemplateAspectRatio;
                                backOffsetX = (canvasWidth - backDrawWidth) / 2;
                                // backOffsetX = 0;
                            }

                            // Draw the back template image on the second canvas
                            offscreenContextBack.drawImage(
                                backTemplateImage,
                                backOffsetX,
                                backOffsetY,
                                backDrawWidth,
                                backDrawHeight
                            );

                             // Draw the profile image
                            const signatureImage = new Image();
                            signatureImage.src = signature.value
                            signatureImage.onload = () => {
                                offscreenContextBack.drawImage(
                                    signatureImage,
                                    signatureX.value,
                                    signatureY.value,
                                    signatureWidth.value,
                                    signatureHeight.value
                                );

                                // Draw the text elements
                                if (textContentsBack.value) {
                                    textContentsBack.value.forEach((textContent, index) => {
                                        // console.log(textContent.content)
                                        offscreenContextBack.font = `${textContent.fontSize}px Arial`;
                                        contextBack.fillStyle = "black"; // Apply selection style
                                        offscreenContextBack.fillText(
                                        textContent.content,
                                        textContent.x,
                                        textContent.y
                                        );
                                    });
                                }
                                contextBack.clearRect(0, 0, canvasWidth, canvasHeight);
                                contextBack.drawImage(offscreenCanvas, 0, 0);
                            }
                            
                        
                            // ...
                        };
                    };

                    
                };
                
            }
            } catch (error) {
                console.log("no id selected")
            }
        };

        const getContentPositions = () => {
            const positions = {};

            // Add canvas size
            positions.canvas = {
                width: canvasWidth.value * 2,
                height: canvasHeight.value * 2,
            };

            // Add profile image position
            positions.profile = {
                x: profileX.value * 2,
                y: profileY.value * 2,
                width: profileWidth.value * 2,
                height: profileHeight.value * 2,
            };

            // Add signature position
            positions.signature = {
                x: signatureX.value,
                y: signatureY.value,
                with: signatureWidth.value,
                height: signatureHeight.value,
            }

            // Add text elements positions
            positions.textContents = textContents.value.map(
                (textContent, index) => ({
                    id: index,
                    content: textContent.content,
                    x: textContent.x * 2,
                    y: textContent.y * 2,
                    fontSize: textContent.fontSize * 2,
                })
            );

            positions.textContentsBack = textContentsBack.value.map(
                (textContentBack, index) => ({
                    id: index,
                    content: textContentBack.content,
                    x: textContentBack.x,
                    y: textContentBack.y * 2,
                    fontSize: textContentBack.fontSize * 2,
                })
            )
            positions.templates = {
                template: collegef.value,
                templateBack: collegeb.value
            }

            return positions;
        };

        const sendContentPositions = () => {
            const positions = getContentPositions();

            console.log(positions);
            axios
                .post("api/save-template", positions)
                .then((response) => {
                    console.log(
                        "Content positions sent to the server successfully"
                    );
                    const $toast = useToast();
                    let instance = $toast.success("Successfully updated!", {
                        position: "top-right",
                    });

                    // // Force dismiss specific toast
                    // instance.dismiss();

                    // // Dismiss all opened toast immediately
                    // $toast.clear();
                })
                .catch((error) => {
                    console.error(
                        "Failed to send content positions to the server:",
                        error
                    );
                });
        };


        const handleExportButtonClick = () => {
            sendContentPositions();
        };

        const updateCanvas = () => {
            redrawCanvas();
            requestAnimationFrame(updateCanvas);
        };

        const handleMouseDown = (event) => {
            const rect = canvasRef.value.getBoundingClientRect();
            const offsetX = event.clientX - rect.left;
            const offsetY = event.clientY - rect.top;

            // Check if the mouse is within the profile image
            if (
                offsetX >= profileX.value &&
                offsetX <= profileX.value + profileWidth.value &&
                offsetY >= profileY.value &&
                offsetY <= profileY.value + profileHeight.value
            ) {
                isDragging.value = true;
                draggedElement.value = "image";

                startX.value = offsetX;
                startY.value = offsetY;

                console.log(startX.value)
                console.log(startY.value)
            }

            // Check if the mouse is within any text element
            for (let i = 0; i < textContents.value.length; i++) {
                const textContent = textContents.value[i];
                if (
                    offsetX >= textContent.x &&
                    offsetX <= textContent.x + 200 && // Assuming a maximum width of 200 for text elements
                    offsetY >= textContent.y - textContent.fontSize &&
                    offsetY <= textContent.y
                ) {
                    isDragging.value = true;
                    draggedElement.value = i;

                    // new added
                    selectedContentIndex.value = i; // Set the selected content index

                    startX.value = offsetX;
                    startY.value = offsetY;
                    break;
                }
            }

            // Check if the mouse is within the signature image on the back canvas
            const rectBack = canvasBackRef.value.getBoundingClientRect();
            const offsetXBack = event.clientX - rectBack.left;
            const offsetYBack = event.clientY - rectBack.top;

            if (
                offsetXBack >= signatureX.value &&
                offsetXBack <= signatureX.value + signatureWidth.value &&
                offsetYBack >= signatureY.value &&
                offsetYBack <= signatureY.value + signatureHeight.value
            ) {
                isDraggingBack.value = true;
                draggedElementBack.value = "image";

                startXBack.value = offsetXBack;
                startYBack.value = offsetYBack;
            }

            // Check if the mouse is within any text element on the back canvas
            for (let i = 0; i < textContentsBack.value.length; i++) {
                const textContentBack = textContentsBack.value[i];
                if (
                    offsetXBack >= textContentBack.x &&
                    offsetXBack <= textContentBack.x + 200 && // Assuming a maximum width of 200 for text elements
                    offsetYBack >= textContentBack.y - textContentBack.fontSize &&
                    offsetYBack <= textContentBack.y
                ) {
                    isDraggingBack.value = true;
                    draggedElementBack.value = i;

                    // Set the selected content index
                    selectedContentIndexBack.value = i;

                    startXBack.value = offsetXBack;
                    startYBack.value = offsetYBack;
                    break;
                }
            }
        };

        const handleMouseMove = (event) => {
            if (isDragging.value) {
                const mouseX =
                    event.clientX -
                    canvasRef.value.getBoundingClientRect().left;
                const mouseY =
                    event.clientY - canvasRef.value.getBoundingClientRect().top;
                const diffX = mouseX - startX.value;
                const diffY = mouseY - startY.value;

                if (draggedElement.value === "image") {
                    // Update the profile image position
                    profileX.value += diffX;
                    profileY.value += diffY;
                } else if (typeof draggedElement.value === "number") {
                    // Update the text position
                    const draggedTextContent =
                        textContents.value[draggedElement.value];
                    draggedTextContent.x += diffX;
                    draggedTextContent.y += diffY;

                    // Check if the text element is outside the canvas
                    const canvasWidth = canvasRef.value.width;
                    const canvasHeight = canvasRef.value.height;
                    const textWidth = 200; // Assuming a maximum width of 200 for text elements

                    if (draggedTextContent.x < 0) {
                        draggedTextContent.x = 0;
                    } else if (draggedTextContent.x + textWidth > canvasWidth) {
                        draggedTextContent.x = canvasWidth - textWidth;
                    }

                    if (draggedTextContent.y < 0) {
                        draggedTextContent.y = 0;
                    } else if (draggedTextContent.y > canvasHeight) {
                        draggedTextContent.y = canvasHeight;
                    }
                }

                startX.value = mouseX;
                startY.value = mouseY;

                // Redraw the canvas only when necessary
                if (diffX !== 0 || diffY !== 0) {
                    redrawCanvas();
                }
            }

            if (isDraggingBack.value) {
                const mouseXBack =
                    event.clientX - canvasBackRef.value.getBoundingClientRect().left;
                const mouseYBack =
                    event.clientY - canvasBackRef.value.getBoundingClientRect().top;
                const diffXBack = mouseXBack - startXBack.value;
                const diffYBack = mouseYBack - startYBack.value;

                if (draggedElementBack.value === "image") {
                    // Update the profile image position on the back canvas
                    signatureX.value += diffXBack;
                    signatureY.value += diffYBack;
                } else if (typeof draggedElementBack.value === "number") {
                    // Update the text position on the back canvas
                    const draggedTextContentBack = textContentsBack.value[draggedElementBack.value];
                    draggedTextContentBack.x += diffXBack;
                    draggedTextContentBack.y += diffYBack;

                    // Check if the text element is outside the back canvas
                    const canvasWidthBack = canvasBackRef.value.width;
                    const canvasHeightBack = canvasBackRef.value.height;
                    const textWidthBack = 200; // Assuming a maximum width of 200 for text elements

                    if (draggedTextContentBack.x < 0) {
                        draggedTextContentBack.x = 0;
                    } else if (draggedTextContentBack.x + textWidthBack > canvasWidthBack) {
                        draggedTextContentBack.x = canvasWidthBack - textWidthBack;
                    }

                    if (draggedTextContentBack.y < 0) {
                        draggedTextContentBack.y = 0;
                    } else if (draggedTextContentBack.y > canvasHeightBack) {
                        draggedTextContentBack.y = canvasHeightBack;
                    }
                }

                startXBack.value = mouseXBack;
                startYBack.value = mouseYBack;

                // Redraw the back canvas only when necessary
                if (diffXBack !== 0 || diffYBack !== 0) {
                    redrawCanvas();
                }
            }
        };

        const handleMouseUp = () => {
            isDragging.value = false;
            draggedElement.value = null;
            // new added
            selectedContentIndex.value = null; // Clear the selected content index

            isDraggingBack.value = false;
            draggedElementBack.value = null;
            selectedContentIndexBack.value = null; // Clear the selected content index for the back canvas
        };

        const getImageTemplates = async () => {
            try {
                const response = await axios.get("/api/image-templates");
                imageTemplates.value = response.data;
                console.log(imageTemplates.value);
            } catch (error) {
                console.error(error);
            }
        };

        // hendle the clicked image
        const handleImageClick = async (src) => {
            console.log(src)
            collegef.value = src
            // collegeb.value 
            handleBack(src)
            // get template coordinates when iclicked
            getTemplateCoordinates(src)
            // save it to local storage
            localStorage.setItem('active_id',src)
        }
        // back id map
        const handleBack = async (src) => {
           collegeb.value = src.replace('f','b')
            console.log(collegeb.value)
        }

        // get template contents coordinates
        const getTemplateCoordinates = async(src) => {
            try {
                const activeTemplate = {activeTemplate:src} 
                const response = await axios.get("/api/image-templates-coord", {params: activeTemplate});
                templateCoordinates.value = response.data;
                profileX.value = templateCoordinates.value[0]?.profile_x / 2 || 55 / 2
                profileY.value = templateCoordinates.value[0]?.profile_y / 2 || 87 / 2

                signatureX.value = templateCoordinates.value[0]?.signature_x || (240+64.02)
                signatureY.value = templateCoordinates.value[0]?.signature_y || 75


                console.log(templateCoordinates.value);
            } catch (error) {
                console.error(error);
            }
        }

        onMounted(() => {
            getImageTemplates();
            getTemplateCoordinates('id_template/collegef.png');
            const canvas = canvasRef.value;
            if (canvas) {
                canvas.addEventListener("mousedown", handleMouseDown);
                canvas.addEventListener("mousemove", handleMouseMove);
                canvas.addEventListener("mouseup", handleMouseUp);
                canvas.addEventListener("mouseleave", handleMouseUp);
                redrawCanvas();

                // Update canvas size after mounted
                updateCanvasSize();
            }
            const canvasBack = canvasBackRef.value;
            if (canvasBack) {
                canvasBack.addEventListener("mousedown", handleMouseDown);
                canvasBack.addEventListener("mousemove", handleMouseMove);
                canvasBack.addEventListener("mouseup", handleMouseUp);
                canvasBack.addEventListener("mouseleave", handleMouseUp);
                redrawCanvas();

                // Update canvas size after mounted
                updateCanvasSize();
            }

            updateCanvas();
        });

        // canvas for editing template

        return {
            handleExportButtonClick,
            // saveCanvasAsImage,
            canvasRef,
            canvasBackRef,
            canvasWidth: 1011,
            canvasHeight: 638,
            imageTemplates,
            getImageTemplates,
            handleImageClick
        };
    },
};
</script>
<style scoped>
/* canvas {
    border: 1px solid #b84c4c;
} */
/* .drop-zone {
    height: 200px;
    border: 2px dashed #000;
}
.draggable {
    width: 25%;
    min-height: 6.5em;
    margin: 1rem 0 0 1rem;
    background-color: #29e;
    color: white;
    border-radius: 0.75em;
    padding: 4%;
    touch-action: none;
    user-select: none;
} */
/* Main container */
.main-container {
  width: 80%;
  margin: auto;
  padding-top: 1rem;
}
/* Design for dashboard header */
div.dashboard_header {
    width: 80% !important;
    position: sticky;
    left: 0;
    right: 0;
    width: 100%;
    height: 1rem;
    padding: 10px;
    box-sizing: border-box;
    margin-bottom: 1rem; /* Add margin-bottom to create space below the header */
    /* border: 1px solid red;  */
}
/* for image gallery */
.image-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 10px;
}

.image-item {
    position: relative;
    overflow: hidden;
}

.image-item img {
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.image-item:hover img {
    transform: scale(1.1);
}

.image-item:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-item:hover:before {
    opacity: 1;
}

.image-item:before {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 24px;
    text-align: center;
}

.image-item:before:hover {
    cursor: pointer;
}

/* Design for the generated button ID */
.generate-id-button {
    width: 90%;
    margin: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 13rem;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
}
.generate-id-button:hover {
    background-color: #45a049;
}
/* Style for the ID card icon */
.generate-id-button i {
    margin-right: 0.5rem;
}

.table-main {
    margin-top: 5rem;
}
/* For upload new template */

.upload-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 2rem;
  width: 78%;
  margin: auto;
  margin-top: 3rem
}

.upload-container .form-label {
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
}

.short-input {
  width: 100%;
}

.upload_section {
  display: flex;
  flex-direction: column;
  /* align-items: center; */
  position: relative; /* Add this line */
}

.upload_container {
  margin-bottom: 2rem;
}

.upload_container label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.uploaded_files {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.uploaded_file {
  flex: 0 0 200px;
}

.uploaded_file img {
  width: 100%;
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 0.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

@media screen and (max-width: 1480px) {
    .generate-id-button {
        max-width: 100% !important;
        margin-top: 1rem !important;
        margin-left: 0;
    }
    div.dashboard_header {
        margin-left: 0rem !important;
    }
    .table-main {
        width: 100%;
        margin-left: 0rem !important;
        margin-right: 0rem;
        margin-top: 5rem !important;
    }
}
</style>
