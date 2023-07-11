<template>
    <div class="main-container">
        <div class="dashboard_header" style="margin-left: 13rem">
            <h1 class="fw-bold">View Records</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Student Records
                    </li>
                </ol>
            </nav>
        </div>
        <div
            class="row justify-content-center table-main"
            style="width: 90%; margin-left: 15%"
        >
            <div class="col-md-12">
                <div class="table-responsive" style="max-height: 500px">
                    <table class="table table-hover table-sm" id="myTable">
                        <thead>
                            <tr>
                                <th>Generate</th>
                                <th>Student-ID</th>
                                <th>Last Name</th>
                                <th>Middle Name</th>
                                <th>First Name</th>
                                <!-- <th>Suffix</th> -->
                                <th>Course</th>
                                <!-- <th>Guardian's Name</th>
                                <th>Guardian's Address</th>
                                <th>Guardian's Contact</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Button for generating ID -->
        <!-- data-bs-toggle="modal"
                            data-bs-target="#bulkPreviewModal" -->
        <button type="button" class="btn btn-success mt-3 fw-bold generate-id-button" 
        data-bs-toggle="modal" data-bs-target="#bulkPreviewModal" @click="handleGenerateId">
            <i class="fa-solid fa-id-card-clip fa-flip fa-xl"></i> Generate ID 
            <span v-show="selectedIds != 0" class="badge text-bg-danger"> {{ selectedIds }}</span>
            <!-- {{ previewModalVisibleShow  }} -->
        </button>
    </div>
    <!-- view modal -->
    <viewModal v-show="modalVisible" :modalData="modalData" :dataId="dataId"  @close="closeModalView" />
    <editModal v-show="editModalVisible" @close="closeModalEdit" />
    <addModal v-show="addModalVisible" :modalData="modalData" :dataId="dataId" :addModalVisible="addModalVisible" @close="closeModalAdd" />
    <previewId v-id="previewModalVisible" :modalData="modalData" :dataId="dataId" @close="closeModalPreview" />
   
</template>
<script>
import { ref, onMounted, computed, reactive } from "vue";
import axios from 'axios';
// Import the required DataTables styles
import "datatables.net";
import "datatables.net-responsive";
import "datatables.net-buttons-dt";
import "datatables.net-bs4/css/dataTables.bootstrap4.min.css";
import "datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css";
import "datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css";

// Import the required DataTables scripts
import $ from "jquery";
import "jszip";
import "pdfmake";
import "datatables.net";
import "datatables.net-bs4";
import "datatables.net-buttons";
import "datatables.net-buttons-bs4";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print";
import "datatables.net-responsive";
import "datatables.net-responsive-bs4";

// import modal
import viewModal from "./ViewStudentInformation.vue";
import editModal from "./EditStudentInformation.vue";
import addModal from "./AddStudentInformation.vue";
import previewId from "./PreviewId.vue";
// import cameraModal from "./cameraModal.vue";
export default {
    components: {
        viewModal,
        editModal,
        addModal,
        previewId,
        // cameraModal,
    },
    setup() {
        // data-id
        const data_id = ref(null);
        const users = ref([]);
        const modalVisible = ref(false);
        const editModalVisible = ref(false);
        const addModalVisible = ref(false);
        const previewModalVisible = reactive({
            show:false
        });

        // modal is show?
        // const modalShow = ref(false)

        const selectedCheckboxes = reactive({
            pids:[],student_data:[]
        });   

        const modalData = ref(null);
        const dataId = ref(null);
        // view modal function
        const openModalView = async (rowId) => {
            // show modal
            console.log(rowId);
            modalData.value = rowId;
            // modalData.value = selectedCheckboxes.student_data;
            // dataId.value = selectedCheckboxes.pids;
            modalVisible.value = true;
        };
        // close modal
        const closeModalView = async () => {
            // hide modal
            modalVisible.value = false;
        };

        // view modal edit function
        const openModalEdit = async (rowId) => {
            // show modal
            console.log(rowId);
            editModalVisible.value = true;
        };
        // close modal edit
        const closeModalEdit = async () => {
            // hide modal
            editModalVisible.value = false;
        };

        // view modal add function
        const openModalAdd = async (rowId) => {
            // show modal
            console.log(rowId);
            modalData.value = rowId;
            addModalVisible.value = true;
        };
        // close modal add
        const closeModalAdd = async () => {
            // hide modal
            addModalVisible.value = false;
        };
        // view modal add function
        const openModalPreview = async (responsedata,responseid) => {
            // show modal
            console.log("open");
            previewModalVisible.show = true;
            modalData.value = responsedata;
            dataId.value = responseid;
        };
        // close modal add
        const closeModalPreview = async () => {
            // hide modal
            console.log("close");
            previewModalVisible.show = false;
            modalData.value = null;
            dataId.value = null;
        };
        const fetchUsers = async () => {
            // hardcoded user data for testing
            // const initialUsers = [
            //     {
            //         id: 1,
            //         last_name: "Abutar",
            //         middle_name: "Chanco",
            //         first_name: "Christian Paul",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 2,
            //         last_name: "Esconde",
            //         middle_name: "Sacdalan",
            //         first_name: "Kyneth",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 3,
            //         last_name: "Bugay",
            //         middle_name: "",
            //         first_name: "Takatoshi",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 4,
            //         last_name: "Doe",
            //         middle_name: "John",
            //         first_name: "Jane",
            //         suffix: "",
            //         type: "High School Student",
            //     },
            //     {
            //         id: 5,
            //         last_name: "Smith",
            //         middle_name: "Alex",
            //         first_name: "Emily",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 6,
            //         last_name: "Gonzalez",
            //         middle_name: "Maria",
            //         first_name: "Carlos",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     // Add more data here
            //     {
            //         id: 7,
            //         last_name: "Garcia",
            //         middle_name: "Andres",
            //         first_name: "Sofia",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 8,
            //         last_name: "Lee",
            //         middle_name: "Ji-hoon",
            //         first_name: "Seo-yeon",
            //         suffix: "",
            //         type: "High School Student",
            //     },
            //     {
            //         id: 9,
            //         last_name: "Wang",
            //         middle_name: "Li",
            //         first_name: "Wei",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 10,
            //         last_name: "Lopez",
            //         middle_name: "Isabella",
            //         first_name: "Mateo",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 11,
            //         last_name: "Chen",
            //         middle_name: "Xiao",
            //         first_name: "Ling",
            //         suffix: "",
            //         type: "High School Student",
            //     },
            //     {
            //         id: 12,
            //         last_name: "Gupta",
            //         middle_name: "Aarav",
            //         first_name: "Anika",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 13,
            //         last_name: "Martinez",
            //         middle_name: "Diego",
            //         first_name: "Sofia",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 14,
            //         last_name: "Nguyen",
            //         middle_name: "Minh",
            //         first_name: "Linh",
            //         suffix: "",
            //         type: "High School Student",
            //     },
            //     {
            //         id: 15,
            //         last_name: "Kim",
            //         middle_name: "Min-ji",
            //         first_name: "Jae-hyun",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 16,
            //         last_name: "Gonzales",
            //         middle_name: "Luis",
            //         first_name: "Camila",
            //         suffix: "",
            //         type: "College Student",
            //     },
            //     {
            //         id: 17,
            //         last_name: "Patel",
            //         middle_name: "Aarav",
            //         first_name: "Neha",
            //         suffix: "",
            //         type: "High School Student",
            //     },
            //     {
            //         id: 18,
            //         last_name: "Suzuki",
            //         middle_name: "Hiroshi",
            //         first_name: "Yumi",
            //         suffix: "",
            //         type: "College Student",
            //     },
            // ];
            // users.value = initialUsers;

            // try {
            //     const response = await axios.get('/api/students'); // Adjust the API endpoint URL as needed
            //     users.value = JSON.parse(response.data);
            //     console.log(users.value)
            // } catch (error) {
            //     console.error(error);
            // }
        };

        onMounted(async () => {
            // to avoid duplication
            // await fetchUsers();
            // Define an array to store the selected checkbox IDs
            // let selectedCheckboxes = { pids: [], student_data:[] };
            try {
                const response = await axios.get('/api/students'); // Adjust the API endpoint URL as needed
                users.value = JSON.parse(response.data);
                console.log(users.value.data)
                const table = $("#myTable").DataTable({
                data: users.value.data.map(item =>{
                    return {
                        generate_id: item.id,
                        student_id: item.student_no,
                        last_name: item.last_name,
                        middle_name: item.middle_name,
                        first_name: item.first_name,
                        type: item.college,
                        // suffix: item.suffix || 'not available',
                        // guardian_name: item.guardian_name || 'not available',
                        // guardian_address: item.guardian_address || 'not available',
                        // guardian_contact: item.guardian_contact_no || 'not available',
                        
                    }
                }),
                responsive: true,
                dom:
                    "<'row'<'col-sm-12 col-md-8'l><'col-sm-12 col-md-3'f>>" +
                    "<'row'<'col-sm-12'rt>>" +
                    "<'row'<'col-sm-12 col-md-7'i><'col-sm-12 col-md-5'p>>" +
                    "<'row'<'col-sm-12 col-md-12'B>>",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn btn-primary mr-1",
                        text: '<i class="fas fa-copy"></i> Copy',
                    },
                    {
                        extend: "csv",
                        className: "btn btn-success mr-1",
                        text: '<i class="fas fa-file-csv"></i> CSV',
                    },
                    {
                        extend: "pdf",
                        className: "btn btn-danger mr-1",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                    },
                    {
                        extend: "print",
                        className: "btn btn-warning",
                        text: '<i class="fas fa-print"></i> Print',
                    },
                ],
                

                columns: [
                     // checkbox for generate id
                     {
                        data:"generate_id",
                        render: (data, type, row) => {
                            return `
                            <th scope="row">
                                <input class="form-check-input" type="checkbox" data-id="${row.generate_id}">
                                PID: ${row.generate_id}
                            </th>
                                `;
                        },
                    },
                    { data: "student_id" },
                    { data: "last_name" },
                    { data: "middle_name" },
                    { data: "first_name" },
                    // { data: "suffix"},
                    { data: "type" },
                    // { data: "guardian_name" },
                    // { data: "guardian_address" },
                    // { data: "guardian_contact" },
                    // Button for View
                    {
                        data: null,
                        render: (data, type, row) => {
                            // <button type="button" class="btn btn-warning edit" data-bs-toggle="modal"
                            // data-bs-target="#editModal"
                            // data-bs-whatever="@getbootstrap">Edit</button>
                            return `
                            <button type="button" class="btn btn-primary view" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                            data-bs-whatever="@getbootstrap" data-id="${row.generate_id}">View</button>

                            

                            <button type="button" class="btn btn-success add" data-bs-toggle="modal"
                            data-bs-target="#addModal"
                            data-bs-whatever="@getbootstrap" data-id="${row.generate_id}">Add${row.generate_id}</button>                 
                            `;
                        },
                        orderable: false,
                        searchable: false,
                    },
                ],
                initComplete: function () {
                // Create a new toolbar container element
                const toolbar = $("<div class='toolbar-container'></div>");
                // Prepend the toolbar container to the first child row of the DataTables wrapper
                $(".dataTables_wrapper .row:first-child").prepend(toolbar);

                // Event handler for checkbox change
                $(document).ready(function(){
                    $('#myTable').on('change', '.form-check-input', function() {
                    const id = $(this).data('id');
                    const row = $(this).closest('tr'); // Get the closest row element

                    if ($(this).is(':checked')) {
                    // Add the selected ID to the array if checked
                    selectedCheckboxes.pids.push(id);
                    
                        // Get the data of the clicked row
                    const table = $('#myTable').DataTable();
                    const rowData = table.row(row).data();

                    
                    selectedCheckboxes.student_data.push(rowData);
                    // Log the data of the clicked row
                    console.log('Clicked Row Data:', rowData);


                    } else {
                    // Remove the selected ID from the array if unchecked
                    // const index = selectedCheckboxes.pids.indexOf(id);
                     // Remove the selected ID and row from the arrays if unchecked
                    const index = selectedCheckboxes.pids.indexOf(id);
                    if (index !== -1) {
                        selectedCheckboxes.pids.splice(index, 1);
                        selectedCheckboxes.student_data.splice(index, 1);
                    }
                    }

                    console.log(selectedCheckboxes)
                });
                })
                },
                
                
            });
            // view
            $("#myTable").on("click", ".view", function () {
                // console.log(this.value.dataset.id)
                const rowIndex = table.row($(this).closest("tr")).index();
                const rowData = table.row(rowIndex).data();
                console.log(rowData)
                data_id.value =  parseInt(this.getAttribute('data-id'), 10);
                // console.log(this.getAttribute('data-id')); // Access data-id attribute using getAttribute
                // pass the id of row click
                openModalView(data_id);
            });

            // edit
            // $("#myTable").on("click", ".edit", function () {
            //     const rowIndex = table.row($(this).closest("tr")).index();
            //     const rowData = table.row(rowIndex).data();
            //     // pass the id of row click
            //     openModalEdit(rowData.id);
            // });

            // add
            $("#myTable").on("click", ".add", function () {
                const rowIndex = table.row($(this).closest("tr")).index();
                const rowData = table.row(rowIndex).data();

                data_id.value =  parseInt(this.getAttribute('data-id'), 10);
                // pass the id of row click
                openModalAdd(data_id);
                // Emit the custom event with the ID for going back
                // t/his.$emit("open-modal-add", rowData.id);
            });
            } catch (error) {
                console.error(error);
            }

            
            
        });

        // Compute the selected IDs from selectedCheckboxes
        const selectedIds = computed(() => {
            // the length of selected student
            // we need to pass those id in a controller we used axios for now
            return selectedCheckboxes.pids.length;
        });

        // const previewModalVisibleShow = computed(()=>{
        //     return previewModalVisible.show == true ? true : false
        // })
       
        // Method to handle the generate ID button click
        const handleGenerateId = async () => {
            console.log('Generated ID:', selectedCheckboxes.pids);
            const headers = {
                    'Accept': 'application/vnd.api+json',
                    'Content-Type': 'application/vnd.api+json',
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                    }
                   await axios.post('/api/generateId',{ headers: headers, params: { id: selectedCheckboxes.pids.length, st_id: selectedCheckboxes.student_data } })
                    .then((res)=>{
                    console.log(res.data)
                    openModalPreview(res.data.path, res.data.id)
                    })

                    .catch((err)=>{
                    console.log(err)
                   
                    
                })
        
        };
       
        return { 
            selectedIds,
            users,
            modalVisible,
            closeModalView,
            openModalView,
            closeModalEdit,
            openModalEdit,
            openModalAdd,
            editModalVisible,
            addModalVisible,
            closeModalAdd,
            openModalPreview,
            previewModalVisible,
            closeModalPreview,
            handleGenerateId,
            modalData,
            dataId,
            // previewModalVisibleShow
           
        };
    },
};
</script>
<style scoped>
/* Main container */
.main-container {
    width: 90%;
    margin: auto;
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
/* Design for the data-table */
.table {
    width: 100%;
    border-collapse: collapse;
}
.table th,
.table td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #f2f2f2;
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
