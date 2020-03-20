<template>
  <el-form :model="temp" label-width="70px" style="width: 80%; margin-left:10%; margin-top:5%">
    <el-form-item :label="$t('table.name')">
      <el-input
        v-model="temp.name"
        :autosize="{ minRows: 2, maxRows: 4 }"
        type="input"
        placeholder="Please input"
      />
    </el-form-item>
  </el-form>
</template>

<script>
export default {
  data(){
    return {
      temp:{
        name:''
      }
    }
  }
};
</script>
