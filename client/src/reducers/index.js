import { combineReducers } from 'redux';
import authReducer from './authReducer';
import problemsReducer from './problemsReducer';
import tagsReducer from './tagsReducer';

export default combineReducers({
  problems: problemsReducer,
  tags: tagsReducer,
  auth: authReducer,
});