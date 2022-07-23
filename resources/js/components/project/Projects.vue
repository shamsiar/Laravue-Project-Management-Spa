<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Project List</h3>

                            <div class="card-tools">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    @click="newModal"
                                >
                                    <i class="fa fa-plus-square"></i>
                                    Add New
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Detail</th>
                                        <th>Created by</th>
                                        <th>Group</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="project in projects.data"
                                        :key="project.id"
                                    >
                                        <td>{{ project.id }}</td>
                                        <td>{{ project.title }}</td>
                                        <td>
                                            {{
                                                project.detail
                                                    | truncate(30, "...")
                                            }}
                                        </td>
                                        <td>{{ project.user.name }}</td>
                                        <td>{{ project.group.title }}</td>
                                        <td>{{ project.created_at }}</td>
                                        <!-- <td><img v-bind:src="'/' + project.photo" width="100" alt="project"></td> -->
                                        <td>
                                            <a
                                                href="#"
                                                @click="editModal(project)"
                                            >
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                            /
                                            <a
                                                href="#"
                                                @click="
                                                    deleteProject(project.id)
                                                "
                                            >
                                                <i class="fa fa-trash red"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <pagination
                                :data="projects"
                                @pagination-change-page="getResults"
                            ></pagination>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <!-- Modal -->
            <div
                class="modal fade"
                id="addNew"
                tabindex="-1"
                role="dialog"
                aria-labelledby="addNew"
                aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode">
                                Create New Project
                            </h5>
                            <h5 class="modal-title" v-show="editmode">
                                Edit Project
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form
                            @submit.prevent="
                                editmode ? updateProject() : createProject()
                            "
                        >
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input
                                        v-model="form.title"
                                        type="text"
                                        name="title"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                form.errors.has('title'),
                                        }"
                                    />
                                    <has-error
                                        :form="form"
                                        field="title"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Details</label>
                                    <input
                                        v-model="form.detail"
                                        type="text"
                                        name="detail"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                form.errors.has('detail'),
                                        }"
                                    />
                                    <has-error
                                        :form="form"
                                        field="detail"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Group</label>
                                    <select
                                        class="form-control"
                                        v-model="form.group_id"
                                    >
                                        <option
                                            v-for="(title, index) in groups"
                                            :key="index"
                                            :value="index"
                                            :selected="index == form.group_id"
                                        >
                                            {{ title }}
                                        </option>
                                    </select>
                                    <has-error
                                        :form="form"
                                        field="group_id"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Members</label>
                                    <select
                                        class="form-control"
                                        v-model="member_ids"
                                        multiple
                                    >
                                        <option
                                            v-for="(member, index) in members"
                                            :key="index"
                                            :value="index"
                                        >
                                            {{ member }}
                                        </option>
                                    </select>
                                    <has-error
                                        :form="form"
                                        field="group_id"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Tasks</label>
                                    <vue-tags-input
                                        v-model="form.tag"
                                        :tags="form.tags"
                                        :autocomplete-items="filteredItems"
                                        @tags-changed="
                                            (newTags) => (form.tags = newTags)
                                        "
                                    />
                                    <has-error
                                        :form="form"
                                        field="tags"
                                    ></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                                >
                                    Close
                                </button>
                                <button
                                    v-show="editmode"
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    Update
                                </button>
                                <button
                                    v-show="!editmode"
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Create
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import VueTagsInput from "@johmun/vue-tags-input";

export default {
    components: {
        VueTagsInput,
    },
    data() {
        return {
            editmode: false,
            projects: {},
            form: new Form({
                id: "",
                group: "",
                user: "",
                title: "",
                detail: "",
                members: [],
                tags: [],
                member_id: "",
                group_id: "",
                user_id: "",
            }),
            groups: [],
            tag: "",
            members: [],
            autocompleteItems: [],
            member_ids: [],
        };
    },
    methods: {
        getResults(page = 1) {
            this.$Progress.start();

            axios
                .get("api/project?page=" + page)
                .then(({ data }) => (this.projects = data.data));

            this.$Progress.finish();
        },
        loadProjects() {
            // if(this.$gate.isAdmin()){
            axios
                .get("api/project")
                .then(({ data }) => (this.projects = data.data));
            // }
            // console.log(data);
        },
        loadGroups() {
            axios
                .get("/api/group/list")
                .then(({ data }) => (this.groups = data.data));
        },
        loadUsers() {
            axios
                .get("/api/user/list")
                .then(({ data }) => (this.members = data.data));
        },
        loadTags() {
            axios
                .get("/api/tag/list")
                .then((response) => {
                    this.autocompleteItems = response.data.data.map((a) => {
                        return { text: a.name, id: a.id };
                    });
                })
                .catch(() => console.warn("Oh. Something went wrong"));
        },
        editModal(project) {
            // console.log(project.members);
            project.members.forEach((member) => {
                this.member_ids.push(member.id);
            });
            // console.log(this.member_ids);
            this.editmode = true;
            this.form.reset();
            $("#addNew").modal("show");
            this.form.fill(project);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $("#addNew").modal("show");
        },
        createProject() {
            this.$Progress.start();

            this.form
                .post("api/project")
                .then((data) => {
                    if (data.data.success) {
                        $("#addNew").modal("hide");

                        Toast.fire({
                            icon: "success",
                            title: data.data.message,
                        });
                        this.$Progress.finish();
                        this.loadProjects();
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: "Some error occured! Please try again",
                        });

                        this.$Progress.failed();
                    }
                })
                .catch(() => {
                    Toast.fire({
                        icon: "error",
                        title: "Some error occured! Please try again",
                    });
                });
        },
        updateProject() {
            this.$Progress.start();
            this.form
                .put("api/project/" + this.form.id)
                .then((response) => {
                    // success
                    $("#addNew").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                    this.$Progress.finish();
                    //  Fire.$emit('AfterCreate');

                    this.loadProjects();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
        deleteProject(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                // Send request to the server
                if (result.value) {
                    this.form
                        .delete("api/project/" + id)
                        .then(() => {
                            Swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            // Fire.$emit('AfterCreate');
                            this.loadProjects();
                        })
                        .catch((data) => {
                            Swal.fire("Failed!", data.message, "warning");
                        });
                }
            });
        },
    },
    mounted() {},
    created() {
        this.$Progress.start();

        this.loadProjects();
        this.loadGroups();
        this.loadUsers();
        this.loadTags();

        this.$Progress.finish();
    },
    filters: {
        truncate: function (text, length, suffix) {
            return text.substring(0, length) + suffix;
        },
    },
    computed: {
        selectedMembers() {
            console.log(this.project.members);
        },

        filteredItems() {
            return this.autocompleteItems.filter((i) => {
                return (
                    i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1
                );
            });
        },
    },
};
</script>
