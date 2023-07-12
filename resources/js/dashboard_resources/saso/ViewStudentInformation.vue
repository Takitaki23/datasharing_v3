<template>
    <div>
        <!-- Preview Modal -->
        <div
            class="modal fade"
            id="previewModal"
            tabindex="-1"
            aria-labelledby="previewModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewModalLabel">
                            Preview ID Card
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div
                        class="modal-body row"
                        style="height: 400px; overflow: hidden"
                    >
                        <!-- Content for ID preview -->
                        <!-- <p>Preview ID Card content goes here...</p> -->
                        <div class="col-sm-6">
                            <canvas
                                ref="canvasRef"
                                :width="canvasWidth"
                                :height="canvasHeight"
                            ></canvas>
                            <!-- <h5 class="text-success text-center">Preview ID Front</h5> -->
                        </div>
                        <div class="col-md-6" style="height: 380px;overflow: hidden;">
                            <canvas class="" ref="canvasBackRef" :width="canvasWidth" :height="canvasHeight"></canvas>
                        </div>
                        <!-- for back of id -->
                        <!-- <div class="col-sm-6">
              <canvas ref="canvasRef" :width="canvasWidth" :height="canvasHeight"></canvas>
            </div> -->
                        <!-- <canvas ref="canvasRef" :width="canvasWidth" :height="canvasHeight"></canvas> -->
                        <!-- <div id="imageContainer">
              
            </div> -->
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="handleExportButtonClick()"
                        >
                            Save Changes
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                        >
                            Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            View Student Information
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body" :key="st_id">
                        <!-- Student Info -->
                        <!-- to refresh the data add a key -->
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label fw-bold"
                                        >Student Number:</label
                                    >
                                    <br />
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >{{ responseData.student_no }}</label
                                    >
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label fw-bold"
                                        >Last Name:</label
                                    >
                                    <br />
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >{{ responseData.last_name }}</label
                                    >
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label
                                        for="message-text"
                                        class="col-form-label fw-bold"
                                        >Middle Name:</label
                                    >
                                    <br />
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >{{ responseData.middle_name }}</label
                                    >
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label
                                        for="message-text"
                                        class="col-form-label fw-bold"
                                        >First Name:</label
                                    >
                                    <br />
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >{{ responseData.first_name }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label fw-bold"
                                        >Suffix</label
                                    >
                                    <br />
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >{{ responseData.suffix }}</label
                                    >
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label fw-bold"
                                        >Course</label
                                    >
                                    <br />
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >{{ responseData.course }}</label
                                    >
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label fw-bold"
                                        >Type</label
                                    >
                                    <br />
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >{{ responseData.college }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- Guardian's Info -->
                        <h5 class="modal-title" id="exampleModalLabel">
                            Guardian's Information
                        </h5>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label
                                        for="message-text"
                                        class="col-form-label fw-bold"
                                        >Guardian's Name:</label
                                    >
                                    <br />
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >{{ responseData.guardian_name }}</label
                                    >
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label
                                        for="message-text"
                                        class="col-form-labe fw-bold"
                                        >Guardian's Address:</label
                                    >
                                    <br />
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >{{
                                            responseData.guardian_address
                                        }}</label
                                    >
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label
                                        for="message-text"
                                        class="col-form-label fw-bold"
                                        >Guardian's Contact:</label
                                    >
                                    <br />
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >{{
                                            responseData.guardian_contact_no
                                        }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <i
                                        class="fa-solid fa-thumbtack thumbtack-icon"
                                    ></i>
                                    <div class="card-header">
                                        <h6 class="ms-3 text-light">
                                            Identification Card Picture
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <div
                                            class="d-flex justify-content-center"
                                        >
                                            <img
                                                :src="image_src"
                                                alt=""
                                                style="background-color: white"
                                            />
                                        </div>
                                        <div class="mt-3">
                                            <button
                                                class="btn btn-primary w-100 mb-3"
                                            >
                                                <i
                                                    class="fa-solid fa-eye me-2"
                                                ></i
                                                >View Picture
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <i
                                        class="fa-solid fa-thumbtack thumbtack-icon"
                                    ></i>
                                    <div class="card-header">
                                        <h6 class="ms-3 text-light">
                                            Identification Card Signature
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <div
                                            class="d-flex justify-content-center"
                                        >
                                            <img
                                                :src="image_signature"
                                                alt=""
                                                style="background-color: white"
                                            />
                                        </div>
                                        <div class="mt-3">
                                            <button
                                                class="btn btn-primary w-100 mb-3"
                                                type="file"
                                            >
                                                <i
                                                    class="fa-solid fa-eye me-2"
                                                ></i
                                                >View Signature
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-primary text-center"
                            data-bs-toggle="modal"
                            data-bs-target="#previewModal"
                            
                        >
                            <i class="fa-solid fa-id-card"></i> Preview ID
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// import { useToast } from "vue-toastification";
import axios from "axios";
import {ref,onMounted,getCurrentInstance,computed,watch} from "vue";
// import collegef from "../../images/collegef.png";
// import collegeb from "../../images/collegeb.png";
import profile from "../../images/man.png";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
// import 'vue-toast-notification/dist/theme-default.css';
// import { ref, computed, reactive } from 'vue';
export default {
    props: ["modalData", "dataId"],
    name: "IdCardGenerator",
    setup(props) {
        //  Get toast interface
        // const toast = useToast();
        let modalDataValue = ref({
            state: "",
        });
        const responseData = ref({});
        let st_id = ref(null);
        const users = ref([]);

        // accessing public folder in laravel
        const image_src = ref("/id_template/jhsf.png");
        const image_signature = ref("/id_signatures/1685325544.png");
        let signature = ref('/id_signatures/1685325544.png')
        // template coordinates
        const templateCoordinates = ref([]);
        // student id coordinates
        const idCoordinates = ref([]);
        const collegef = ref(null)
        const collegeb = ref(null)
        // return the id
        const statePath = computed(async () => {
            try {
                // Add null checks for props.modalData and props.modalData.value
                if (props.modalData && props.modalData.value) {
                    // console.log('Sending request with path:', props.modalData.value);
                    const response = await axios.get(`/api/students`);
                    users.value = JSON.parse(response.data);
                    // map to a data
                    // console.log(users.value.data.find((item) => item.id === props.modalData.value) || null)
                    responseData.value =
                        users.value.data.find(
                            (item) => item.id === props.modalData.value
                        ) || null;
                    // console.table(responseData.value)
                    redrawCanvas();
                    // getIdCoordinates()
                    return (modalDataValue.state = props.modalData);
                }
            } catch (error) {
                console.error(error);
            }
        });

        watch(
            () => props.modalData,
            (newModalData) => {
                modalDataValue.value = newModalData;
            }
        );

        // Create a hidden canvas for double buffering
        const hiddenCanvas = document.createElement("canvas");
        const hiddenContext = hiddenCanvas.getContext("2d");

        // Add a selectedContentIndex reactive variable
        const selectedContentIndex = ref(null);
        const selectedContentIndexBack = ref(null);

        const instance = getCurrentInstance();
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


        watch(statePath, () => {
            console.log(statePath);
            redrawCanvas();
        });

        // Use a watch property to trigger getIdCoordinates when responseData.value.student_no changes
        watch(() => responseData.value.student_no, (newStudentNo) => {
            console.log(newStudentNo)
            getIdCoordinates(newStudentNo);
            // get active templates from local storage
            const act_Tmp = localStorage.getItem('active_id')
            getTemplateCoordinates(act_Tmp);
        });

        const textContents = computed(() => {
            console.log(responseData.value.student_no);
            // getIdCoordinates(responseData.value.student_no)
            
            const st_id_s = responseData.value.student_no
                ? responseData.value.student_no
                : "";

            const course_s = responseData.value.course
                ? responseData.value.course
                : "";
            const last_name = responseData.value.last_name
                ? responseData.value.last_name
                : "";
            const first_name = responseData.value.first_name
                ? responseData.value.first_name
                : "";
            const middle_name = responseData.value.middle_name
                ? responseData.value.middle_name
                : "";
            // we devided by 2 to make it smaller
            return [
                { content: st_id_s, 
                    x: (idCoordinates.value?.textContents_0_x || 280) / 2, 
                    y: (idCoordinates.value?.textContents_0_y || 550) / 2, 
                    fontSize: 35 / 2,
                    fonts: "Helvetica-Bold",
                    colors: "rgb("+(idCoordinates.value?.rgb_color_secondary || 'black')+")" 
                },
                { content: course_s, 
                    x: (idCoordinates.value?.textContents_1_x || 45) / 2, 
                    y:(idCoordinates.value?.textContents_1_y || 590) / 2, 
                    fontSize: 25 / 2,
                    fonts: 'Helvetica',
                    colors: "rgb("+(idCoordinates.value?.rgb_color_primary || 'black')+")"
                },
                {
                    content: last_name,
                    x: (idCoordinates.value?.textContents_2_x || 430) / 2,
                    y: (idCoordinates.value?.textContents_2_y || 370) / 2,
                    fontSize: 45 / 2,
                    fonts: 'Helvetica-Bold',
                    colors: "rgb("+(idCoordinates.value?.rgb_color_primary || 'black')+")"
                },
                {
                    content: first_name,
                    x: (idCoordinates.value?.textContents_3_x || 430) / 2,
                    y: (idCoordinates.value?.textContents_3_y || 420) / 2,
                    fontSize: 45 / 2,
                    fonts: 'Helvetica',
                    colors: "rgb("+(idCoordinates.value?.rgb_color_primary || 'black')+")"
                },
                {
                    content: middle_name,
                    x: (idCoordinates.value?.textContents_4_x || 430) / 2,
                    y: (idCoordinates.value?.textContents_4_y || 470) / 2,
                    fontSize: 45 / 2,
                    fonts: 'Helvetica',
                    colors: "rgb("+(idCoordinates.value?.rgb_color_primary || 'black')+")"
                },
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
                {content: ecp, x:(idCoordinates.value[0]?.textContentsBack_0_x || 310), y:(idCoordinates.value[0]?.textContentsBack_0_y || 120) / 2,fontSize:30/2},
                {content: address1, x:(idCoordinates.value[0]?.textContentsBack_1_x || 280),y:(idCoordinates.value[0]?.textContentsBack_1_y ||160)/2,fontSize:22/2},
                // {content: barangay, x:255,y:0,fontSize:25},
                // {content: address2, x:255,y:122,fontSize:25/2},
                // {content: province, x:0,y:0,fontSize:0},
                {content: ecpc, x:(idCoordinates.value[0]?.textContentsBack_2_x ||340),y:(idCoordinates.value[0]?.textContentsBack_2_y ||200)/2,fontSize:25/2},
                {content: semester, x:(idCoordinates.value[0]?.textContentsBack_3_x ||35),y:(idCoordinates.value[0]?.textContentsBack_3_y || 500)/2,fontSize:30/2},
            ]
        })

        const saveImageToLocal = (imageData) => {
            localStorage.setItem("generatedImage", imageData);
            console.log("Image saved to local storage");
        };

        const displayImage = (imageData) => {
            const imageContainer = document.getElementById("imageContainer");

            const imageElement = document.createElement("img");
            imageElement.src = imageData;

            imageContainer.appendChild(imageElement);
        };

        const updateCanvasSize = () => {
            const canvas = canvasRef.value;
            const canvasBack = canvasBackRef.value;
            if (canvas && canvasBack) {
                // we devided by 2 to make it smaller
                canvasWidth.value = canvas.width / 2;
                canvasHeight.value = canvas.height / 2;
            }
        };
        // new redraw
        const redrawCanvas = () => {
            const canvas = canvasRef.value;
            const canvasBack = canvasBackRef.value;
            if (canvas && canvasBack) {
                const context = canvas.getContext("2d");
                const contextBack = canvasBack.getContext("2d");
                // we devided by 2 to make it smaller
                const canvasWidth = canvas.width / 2;
                const canvasHeight = canvas.height / 2;
                // back
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
               
                // Clear the offscreen canvas
                offscreenContext.clearRect(0, 0, canvasWidth, canvasHeight);

                // Clear the offscreen canvas2
                offscreenContextBack.clearRect(0, 0, canvasWidth, canvasHeight);

                // draw the back
                const backTemplateImage = new Image();

                // Draw the template image
                const templateImage = new Image();
                templateImage.src = collegef.value;

                templateImage.onload = () => {
                    const templateAspectRatio =
                        templateImage.width / templateImage.height;
                    const canvasAspectRatio = canvasWidth / canvasHeight;

                    let drawWidth, drawHeight;
                    let offsetX = 0,
                        offsetY = 0;

                    if (templateAspectRatio > canvasAspectRatio) {
                        // Template image is wider than the canvas
                        drawWidth = canvasWidth;
                        drawHeight = drawWidth / templateAspectRatio;
                        offsetY = (canvasHeight - drawHeight) / 2;
                    } else {
                        // Template image is taller than the canvas
                        drawHeight = canvasHeight;
                        drawWidth = drawHeight * templateAspectRatio;
                        offsetX = (canvasWidth - drawWidth) / 2;
                    }

                    // Draw the template image on the offscreen canvas
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
                        textContents.value.forEach((textContent, index) => {
                            offscreenContext.font = `${textContent.fontSize}px ${textContent.fonts}`;
                            offscreenContext.fillStyle = textContent.colors;
                            offscreenContext.fillText(
                                textContent.content,
                                textContent.x,
                                textContent.y
                            );
                        });

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
                .post("api/previewID", positions)
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

        // ...

        const handleExportButtonClick = () => {
            sendContentPositions();
        };

        const updateCanvas = () => {
            redrawCanvas();
            requestAnimationFrame(updateCanvas);
        };

        const handleMouseDown = (event) => {
            // front
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

         // get template contents coordinates
         const getTemplateCoordinates = async(src) => {
            try {
                const activeTemplate = {activeTemplate:src} 
                const response = await axios.get("/api/image-templates-coord",{params: activeTemplate});
                templateCoordinates.value = response.data;
                // profileX.value = templateCoordinates.value[0].profile_x / 2
                // profileY.value = templateCoordinates.value[0].profile_y / 2

                // template name
                collegef.value = templateCoordinates.value[0].template_name
                collegeb.value = templateCoordinates.value[0].template_back
                
                console.log(templateCoordinates.value);
            } catch (error) {
                console.error(error);
            }
        }

        // get id contents coordinates in db
        const getIdCoordinates = async(st_id_no) => {
            try {
                // let st_id_no = responseData.value.student_no? responseData.value.student_no: ""
                console.log(st_id_no)
                if(st_id_no){
                    const response = await axios
                    .post("/api/get-generated-id",{st_id_no})
                    .then((res)=>{
                        console.log(res.data)
                        idCoordinates.value = res.data

                        signatureX.value = idCoordinates.value[0]?.signature_x || (240+64.02)
                        signatureY.value = idCoordinates.value[0]?.signature_y || 75
                    })
                    .catch((err)=>{
                        console.log(err)
                    })
                    //templateCoordinates.value = response.data;
                }
                
            } catch (error) {
                console.error(error);
            }
        }
        onMounted(() => {
            // active template
            const active_Tmp =localStorage.getItem('active_id')
            getTemplateCoordinates(active_Tmp)
            // getIdCoordinates()
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

        const saveCanvasAsImage = () => {
            const canvas = canvasRef.value;
            if (canvas) {
                // Create a data URL of the canvas content
                const imageData = canvas.toDataURL("image/png");

                // Create a link element
                const link = document.createElement("a");
                link.href = imageData;
                link.download = "id_card.png";

                // Programmatically trigger a click event on the link
                link.click();
            }
        };

        return {
            handleExportButtonClick,
            saveCanvasAsImage,
            canvasRef,
            canvasBackRef,
            canvasWidth: 1011,
            canvasHeight: 638,
            statePath,
            modalDataValue,
            st_id,
            responseData,
            image_src,
            image_signature,
        };
    },
};
</script>

<style scoped>
/* fcustom fiont */
@font-face {
  font-family: 'Helvetica-Bold';
  src: url('/id_fonts/Helvetica-Bold.ttf') format('truetype');
}

@font-face {
  font-family: 'Helvetica';
  src: url('/id_fonts/Helvetica.ttf') format('truetype');
}


canvas {
    background-color: rgb(95, 178, 95);
    padding: 10px;
    /* border: 1px solid #000; */
}
#previewModal {
    width: 100%;
}
/* Modal Design */
.modal-header {
    background-color: rgb(95, 178, 95);
    color: #ffffff;
}

.modal-body h5 {
    color: rgb(67, 155, 67);
}

.modal-footer {
    background-color: #f8f9fa;
}
.btn-view {
    width: 100%;
}
/* Card Design */
.card-header {
    background-color: rgb(57, 157, 199);
}
/* Thumbtack Icon Design */
.thumbtack-icon {
    color: #ffffff;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: -3px;
    left: 10px;
    z-index: 1;
}
</style>
