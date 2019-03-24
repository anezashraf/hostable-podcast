import React from 'react'
import PropTypes from "prop-types";

class UserForm extends React.Component {
    handleCheck = () => {
      this.props.handleUpdate(this.props.user.id, !this.props.user.enabled)
    };

    render () {
      return (
        <div>
          <p>{this.props.user.username}</p>
          <p>{this.props.user.email}</p>

          <input type='checkbox' checked={this.props.user.enabled} onChange={this.handleCheck}/>
        </div>
      )
    }
}

UserForm.propTypes = {
    handleUpdate: PropTypes.func,
    user: PropTypes.object,
};

export default UserForm
