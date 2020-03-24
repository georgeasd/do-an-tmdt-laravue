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

export function createProductCategory(data) {
  return request({
    url: '/product-categories/',
    method: 'POST',
    data,
  });
}
