import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/product-categories',
    method: 'get',
    params: query,
  });
}
