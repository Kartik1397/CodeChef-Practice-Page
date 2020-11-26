import axios from 'axios';
import { API } from '../config';

export const GET_TAGS = 'GET_TAGS';
export const CREATE_TAG = 'CREATE_TAG';
export const DELETE_TAG = 'DELETE_TAG';
export const MAP_TAG = 'MAP_TAG';
export const UNMAP_TAG = 'UNMAP_TAG';
export const SET_MAP = 'SET_MAP';
export const TAGS_LOADING = 'TAGS_LOADING';

export const getTags = () => dispatch => {
  dispatch({ type: TAGS_LOADING });
  axios
    .get(API + '/tags')
    .then(res => {
      return dispatch({ type: GET_TAGS, payload: res.data.tags });
    });
};

export const createTag = tag => dispatch => {
  dispatch({ type: TAGS_LOADING });
  axios
    .post(API + '/tags', tag)
    .then(res => {
      if (res.data.success === true) {
        dispatch(getTags());
      }
    })
}

export const removeTag = tag => dispatch => {
  dispatch({ type: TAGS_LOADING });
  axios
    .post(API + '/tags/delete', tag)
    .then(res => {
      if (res.data.success === true) {
        dispatch(getTags());
      }
    })
}

export const mapTagProblem = data => dispatch => {
  dispatch({ type: TAGS_LOADING });
  axios
    .post(API + '/tags/map', data)
    .then(res => {
      if (res.data.success === true) {
        dispatch(getTags());
        dispatch(getTagProblemMap());
      }
    })
}

export const unmapTagProblem = data => dispatch => {
  dispatch({ type: TAGS_LOADING });
  axios
    .post(API + '/tags/unmap', data)
    .then(res => {
      if (res.data.success === true) {
        dispatch(getTags());
        dispatch(getTagProblemMap());
      }
    });
}

export const getTagProblemMap = () => dispatch => {
  dispatch({ type: TAGS_LOADING });
  axios
    .get(API + '/tags/map')
    .then(res => {
      if (res.data.success === true) {
        dispatch({type: SET_MAP, payload: res.data.map});
      }
    })
}