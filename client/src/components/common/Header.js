// React
import React from 'react';
import { Link } from 'react-router-dom';

// Redux
import { connect } from 'react-redux';
import { signoutUser } from '../../actions/authAction';

// Components
import SignIn from '../auth/SignIn';
import SignUp from '../auth/SignUp';

// Style
import './header.css';

class Header extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      signIn: false,
      signUp: false
    }

    this.hideSignUpPopUp = this.hideSignUpPopUp.bind(this);
    this.hideSignInPopUp = this.hideSignInPopUp.bind(this);
    this.signOut = this.signOut.bind(this);
  }

  hideSignInPopUp() {
    this.setState({ signIn: false })
  }

  hideSignUpPopUp() {
    this.setState({ signUp: false })
  }

  signOut() {
    this.props.signoutUser();
  }

  render() {
    const { title } = this.props;
    let popup = "";
    if (this.state.signIn) {
      popup = <SignIn close={this.hideSignInPopUp}></SignIn>
    } else if (this.state.signUp) {
      popup = <SignUp close={this.hideSignUpPopUp}></SignUp>
    }
    let authButtons = "";
    let user = ""

    if (this.props.auth.isAuthenticated) {
      user = (
        <div className="buttons">
          <Link to="/user" style={{ textDecoration: "none"}}>
            <div className="userControll"><p>{this.props.auth.user.username}</p></div>
          </Link>
          <div className="button" onClick={this.signOut}>Sign out</div>
        </div>
      );
    } else {
      authButtons = (
        <div className="buttons">
          <div className="button" onClick={() => { this.setState({signIn: true})}}>Sign in</div>
          <div className="button" onClick={() => { this.setState({signUp: true})}}>Sign up</div>
        </div>
      )
    }
    return (
      <>
        <div className="header">
          <Link to="/" style={{ textDecoration: "none", color: "black"}}>
            <div className="title">{title}</div>
          </Link>
          { authButtons }
          { user }
        </div>
        { popup }
      </>
    );
  }
}

var mapStateToProps = state => ({
  auth: state.auth
})

export default connect(
  mapStateToProps,
  { signoutUser }
)(Header);
