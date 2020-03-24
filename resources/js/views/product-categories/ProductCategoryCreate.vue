<template>
  <div class="app-container">
    <el-form ref="form" :model="form" label-width="120px">
      <el-form-item :label="$t('table.name')">
        <el-input v-model="form.name" />
      </el-form-item>

      <el-form-item :label="$t('table.description')">
        <el-input v-model="form.description" type="textarea" />
      </el-form-item>

      <el-form-item :label="$t('table.parent_name')">
        <el-select v-model="form.parent_id">
          <el-option label="Zone one" value="1" />
          <el-option label="Zone two" value="2" />
        </el-select>
      </el-form-item>
      <el-form-item :label="$t('table.status')">
        <el-switch v-model="form.status" />
      </el-form-item>

      <el-form-item :label="$t('table.image')">
        <input type="file" @change="onFileSelected">
        <!-- <el-input type="file" @change="onFileSelected" /> -->
      </el-form-item>

      <el-form-item>
        <el-button type="primary" @click="onSubmit">
          Create
        </el-button>
        <el-button @click="onCancel">
          Cancel
        </el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { createProductCategory, fetchList } from '@/api/product-category.js';
export default {
  data() {
    return {
      form: {
        name: '',
        description: '',
        parent_id: null,
        status: true,
        image: null,
      },
      options: [],
    };
  },
  created(){
    this.getListOptionsParent();
  },
  methods: {
    async getListOptionsParent(){
      try {
        const response = await fetchList();
        this.options = response;
      } catch (error){
        console.log(error);
      }
    },
    onFileSelected(event) {
      const file = event.target.files[0];
      const reader = new FileReader();
      const vm = this;
      reader.onload = e => {
        vm.form.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    async onSubmit() {
      createProductCategory(this.form);
    },
    onCancel() {
      this.$message({
        message: 'cancel!',
        type: 'warning',
      });
    },
  },
};
</script>

<style scoped>
.line {
  text-align: center;
}
</style>
