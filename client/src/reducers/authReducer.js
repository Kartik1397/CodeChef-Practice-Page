import isEmpty from 'is-empty';
import { GET_ERRORS, SET_CURRENT_USER, MAIL_SENT, USER_LOADING } from '../actions/authAction';

const initialState = {
  isAuthenticated: false,
  user: {},
  userLoading: false
};

export default function(state = initialState, action) {
  switch (action.type) {
    case SET_CURRENT_USER:
      return {
        ...state,
        isAuthenticated: !isEmpty(action.payload),
        user: action.payload,
        userLoading: false
      };
    case GET_ERRORS:
      return { errors: action.payload };
    case MAIL_SENT:
      return { 
        ...state,
        mail_sent: true,
        userLoading: false
      }
    case USER_LOADING:
      return { ...state, userLoading: true }
    default:
      return state;
  }
}