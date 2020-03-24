import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/product-categories',
    method: 'get',
    params: query,
  });
}

export function deleteCategory(id) {
  return request({
    url: '/product-categories/' + id,
    method: 'DELETE',
  });
}
