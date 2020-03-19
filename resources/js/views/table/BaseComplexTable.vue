<template>
  <div class="app-container">
    <!-- Filter zone -->
    <div class="filter-container" />
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
import { fetchList } from '@/api/product-category';
import waves from '@/directive/waves'; // Waves directive
import { parseTime } from '@/utils';
import Pagination from '@/components/Pagination';

export default {
  name: 'ProductCategoryList',
  components: { Pagination },
  directives: { waves },
  filters: {},
  data() {
    return {
      tableKey: 0,
      listQuery: {
        page: 1,
        limit: 10,
        sort: '+id',
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

    // Sort methods
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    sortChange(data) {
      const { prop, order } = data;
      if (prop === 'id') {
        this.sortByID(order);
      }
    },
    sortByID(order) {
      if (order === 'ascending') {
        this.listQuery.sort = '+id';
      } else {
        this.listQuery.sort = '-id';
      }
      this.handleFilter();
    },
  },
};
</script>
