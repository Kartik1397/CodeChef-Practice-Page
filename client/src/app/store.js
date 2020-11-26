import { createStore, applyMiddleware, compose } from 'redux';
import rootReducer from '../reducers';
import thunk from 'redux-thunk';

const middleware = [thunk];

const store = createStore(
  rootReducer,
  compose(
    applyMiddleware(...middleware)
  )
);

export default store;