import axios from "axios";
import jwt_decode from 'jwt-decode';
import { API } from '../config';
import { getTags, getTagProblemMap } from './tagsAction';

import setAuthToken from '../utils/setAuthToken';

export const GET_ERRORS = 'GET_ERRORS';
export const SET_CURRENT_USER = 'SET_CURRENT_USER';
export const MAIL_SENT = 'MAIL_SENT';
export const USER_LOADING = 'USER_LOADING';

export const signupUser = user => dispatch => {
  dispatch({ type: USER_LOADING });
  axios
    .post(API + "/user/signup", user)
    .then(res => {
      if (!res.data.success) {
        dispatch({
          type: GET_ERRORS,
          payload: res.data.errors
        });
      } else {
        dispatch({
          type: MAIL_SENT
        });
      }
    })
}

export const signinUser = userData => dispatch => {
  dispatch({ type: USER_LOADING });
  axios
  .post(API + '/user/signin', userData)
  .then(res => {
    window.history.pushState({urlPath: '/'}, "", "/");
    if (!res.data.success) {
        dispatch({
          type: GET_ERRORS,
          payload: res.data.error
        });
        return;
      }
      const { token } = res.data;
      const decoded = jwt_decode(token);
      localStorage.setItem('jwtToken', JSON.stringify(token));
      setAuthToken(token);
      dispatch(setCurrentUser(decoded.user))
      dispatch(getTags());
      dispatch(getTagProblemMap());
    })
}

export const setCurrentUser = user => {
  return {
    type: SET_CURRENT_USER,
    payload: user
  }
}

export const signoutUser = data => dispatch => {
  localStorage.removeItem('jwtToken');
  setAuthToken(false);
  dispatch(setCurrentUser({}));
  dispatch(getTags());
}