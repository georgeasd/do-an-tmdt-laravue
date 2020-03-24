<template>
  <div class="app-container">
    <!-- Filter zone -->
    <div class="filter-container">
      <el-input v-model="listQuery.keyword" :placeholder="$t('table.title')" style="width: 200px;" class="filter-item" @keyup.native="handleFilter" />
      <el-button
        class="filter-item"
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-edit"
        @click="handleCreate"
      >
        {{ $t('table.add') }}
      </el-button>
    </div>
    <!-- !Filter zone -->
    <!-- Main table -->
    <el-table
      :key="tableKey"
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
      @sort-change="sortChange"
    >
      <el-table-column
        :label="$t('table.id')"
        prop="id"
        sortable="custom"
        align="center"
        width="80"
      >
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column
        :label="$t('table.name')"
        min-width="150px"
        prop="name"
        sortable="custom"
        align="center"
      >
        <template slot-scope="{ row }">
          <span>{{ row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column
        :label="$t('table.slug')"
        prop="slug"
        sortable="custom"
        align="center"
      >
        <template slot-scope="{ row }">
          <span>{{ row.slug }}</span>
        </template>
      </el-table-column>

      <el-table-column
        :label="$t('table.description')"
        prop="description"
        sortable="custom"
        align="center"
      >
        <template slot-scope="{ row }">
          <span>{{ row.description }}</span>
        </template>
      </el-table-column>

      <el-table-column
        :label="$t('table.image')"
        prop="image"
        sortable="custom"
        align="center"
      >
        <template slot-scope="{ row }">
          <el-image
            style="width: 100px; height: 100px"
            :src="row.image"
            fit="fit"
          />
        </template>
      </el-table-column>
      <el-table-column
        :label="$t('table.parent_name')"
        prop="parent_name"
        sortable="custom"
        align="center"
      >
        <template slot-scope="{ row }">
          <span>{{ row.parent_name }}</span>
        </template>
      </el-table-column>

      <el-table-column
        :label="$t('table.status')"
        class-name="status-col"
        width="100"
        prop="status"
        sortable="custom"
        align="center"
      >
        <template slot-scope="{ row }">
          <el-tag :type="row.status | statusFilter">
            {{ row.status ? 'On' : 'Off' }}
          </el-tag>
        </template>
      </el-table-column>

      <el-table-column
        :label="$t('table.actions')"
        align="center"
        width="230"
        class-name="small-padding fixed-width"
      >
        <template slot-scope="{ row }">
          <el-button type="primary" size="mini" @click="handleUpdate(row)">
            {{ $t('table.edit') }}
          </el-button>

          <el-button
            size="mini"
            type="danger"
            @click="handleDelete(row)"
          >
            {{ $t('table.delete') }}
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- !Main table -->
    <!-- Pagination -->
    <pagination
      v-show="total > 0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />
    <!-- !Pagination -->
  </div>
</template>

<script>
import { fetchList, deleteCategory } from '@/api/product-category';
import waves from '@/directive/waves'; // Waves directive
import Pagination from '@/components/Pagination';

export default {
  name: 'ProductCategoryList',
  components: { Pagination },
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger',
        1: 'success',
        0: 'danger',
      };
      return statusMap[status];
    },
  },
  data() {
    return {
      tableKey: 0,
      listQuery: {
        page: 1,
        limit: 10,
        sort: 'id',
        orderBy: 'desc',
      },
      list: null,
      listLoading: true,
      total: 0,
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.listLoading = true;
      const response = await fetchList(this.listQuery);
      this.list = response.data;
      this.total = response.meta.total;

      // Just to simulate the time of the request
      this.listLoading = false;
    },
    handleCreate() {
      this.$router.push({ name: 'ProductCategoryCreate' });
    },
    handleDelete(row) {
      this.$confirm(
        'This will delete product category "' +
          row.name +
          '". Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          deleteCategory(row.id)
            .then(response => {
              this.$message({
                type: 'success',
                message: 'Delete completed',
              });
              this.handleFilter();
            })
            .catch(error => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Delete canceled',
          });
        });
    },
    // Sort methods
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    sortChange(data) {
      const { prop, order } = data;
      this.sortByID(prop, order);
    },
    sortByID(prop, order) {
      if (order === 'ascending') {
        this.listQuery.sort = prop;
        this.listQuery.orderBy = 'asc';
      } else {
        this.listQuery.sort = prop;
        this.listQuery.orderBy = 'desc';
      }
      this.handleFilter();
    },
  },
};
</script>
