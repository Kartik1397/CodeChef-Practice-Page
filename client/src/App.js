// React
import React from 'react';
import { BrowserRouter as Router, Route } from "react-router-dom";

// Utils
import jwt_decoded from 'jwt-decode';
import setAuthToken from './utils/setAuthToken';

//Redux
import store from './app/store';
import { connect } from 'react-redux';
import { getTags, getTagProblemMap } from './actions/tagsAction';
import { setCurrentUser } from './actions/authAction';

// Components
import Header from './components/common/Header';
import PracticePage from './components/PracticePage';
import UserPage from './components/user/UserPage';

// Style
import './App.css';

if (localStorage.jwtToken) {
  const token = JSON.parse(localStorage.jwtToken);
  setAuthToken(token);
  const decoded = jwt_decoded(token);
  store.dispatch(setCurrentUser(decoded.user));
}

class App extends React.Component {
  componentDidMount() {
    this.props.getTags();
    if (localStorage.jwtToken) {
      this.props.getTagProblemMap();
    }
  }

  render() {
    return (
      <>
        <Router>
          <Header title="CODECHEF"></Header>
          <Route exact path="/">
            <PracticePage></PracticePage>
          </Route>
          <Route exact path="/user">
            <UserPage></UserPage>
          </Route>
        </Router>
      </>
    );
  }
}

var mapStateToProps = state => ({});

export default connect(
  mapStateToProps,
  { getTags, getTagProblemMap }
)(App);
