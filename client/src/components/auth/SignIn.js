//React
import React from 'react';
import BeatLoader from 'react-spinners/BeatLoader';
import { Redirect } from 'react-router-dom';

// Redux
import { connect } from 'react-redux';
import { signinUser } from '../../actions/authAction';

// styles
import '../common/popup.css';
import '../common/form.css';

class SignIn extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      username: '',
      password: '',
    }

    this.handleChanges = this.handleChanges.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleChanges(e) {
    this.setState({
      [e.target.name]: e.target.value
    })
  }

  handleSubmit(e) {
    e.preventDefault();
    this.props.signinUser(this.state);
  }

  render() {
    if (this.props.auth.isAuthenticated) {
      this.props.close();
      return (
        <Redirect to="/user"/>
      );
    }
    let errors = "";
    if (this.props.auth.errors !== undefined) {
      errors = JSON.stringify(this.props.auth.errors)
    }

    let loading = '';
    if (this.props.auth.userLoading === true) {
      loading = <BeatLoader size={10} />;
    }

    return (
      <div className="popup-container">
        <div className="outside" onClick={() => { this.props.close(); }}></div>
        <div className="flex-popup-card">
          <form className="form" onSubmit={this.handleSubmit}>
            <div className="form-title">Sign in{loading}</div>
            <div>{errors}</div>
            <div className="form-input">
              <label htmlFor="username">Username</label>
              <input type="text" id="username" name="username" onChange={this.handleChanges} required></input>
            </div>
            <div className="form-input">
              <label htmlFor="password">Password</label>
              <input type="password" id="password" name="password" onChange={this.handleChanges} required></input>
            </div>
            <div className="submit">
              <input type="submit" className="form-button" value="SignIn"></input>
            </div>
          </form>
        </div>
      </div>
    );
  }
}

var mapStateToProps = state => ({
  auth: state.auth
});

export default connect(
  mapStateToProps,
  { signinUser }
)(SignIn);