<template>
<div class="container">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>NAME</th>
                <th>AGE</th>
                <th>PHONE</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ tasks.name }}</td>
                <td>{{ tasks.age }}</td>
                <td>{{ tasks.phone }}</td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-6">
            <form action="">
                <input type="text" class="form-control offset-6">
                <input type="button" class="btn btn-sm btn-success" lang="'save'" @click="test">
            </form>
        </div>
    </div>
</div>

</template>
<script>
export default {
    props: {
        tasks: {
            type: Object,
            required: true,
        },
    },

}
</script>