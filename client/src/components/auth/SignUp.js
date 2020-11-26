// React
import React from 'react';
import BeatLoader from 'react-spinners/BeatLoader';

// Redux
import { connect } from 'react-redux';
import { signupUser } from '../../actions/authAction';

// Styles
import '../common/popup.css';
import '../common/form.css';

class SignUp extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      username: '',
      password: '',
      first_name: '',
      last_name: '',
      email: '',
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
    this.props.signupUser(this.state);
  }

  render() {
    let errors = "";
    if (this.props.auth.errors !== undefined) {
      errors = JSON.stringify(this.props.auth.errors)
    }
    let loading = '';
    if (this.props.auth.userLoading === true) {
      loading = <BeatLoader size={10} />;
    }
    if (this.props.auth.mail_sent !== undefined) {
      return (
        <div className="popup-container">
          <div className="outside" onClick={() => { this.props.close(); }}></div>
          <div className="flex-popup-card">
            <form className="form" onSubmit={this.handleSubmit}>
              <div className="form-title">Sign up</div>
              <div className="form-msg">Please check your inbox.</div>
            </form>
          </div>
        </div>
      );
    }
    return (
      <div className="popup-container">
        <div className="outside" onClick={() => { this.props.close(); }}></div>
        <div className="flex-popup-card">
          <form className="form" onSubmit={this.handleSubmit}>
            <div className="form-title">Sign up{loading}</div>
            <div>{errors}</div>
            <div className="form-input">
              <label htmlFor="username">Username</label>
              <input type="text" id="username" name="username" onChange={this.handleChanges} required></input>
            </div>
            <div className="form-input">
              <label htmlFor="firstname">First Name</label>
              <input type="text" id="firstname" name="first_name" onChange={this.handleChanges} required></input>
            </div>
            <div className="form-input">
              <label htmlFor="lastname">Last Name</label>
              <input type="text" id="lastname" name="last_name" onChange={this.handleChanges} required></input>
            </div>
            <div className="form-input">
              <label htmlFor="email">Email</label>
              <input type="email" id="email" name="email" onChange={this.handleChanges} required></input>
            </div>
            <div className="form-input">
              <label htmlFor="password">Password</label>
              <input type="password" id="password" name="password" onChange={this.handleChanges} required></input>
            </div>
            <div className="submit">
              <input type="submit" className="form-button" value="SignUp"></input>
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
  { signupUser }
)(SignUp);
