import React from 'react'

class UserForm extends React.Component {

    handleCheck = (e) => {
        this.props.handleUpdate(this.props.user.id, ! this.props.user.enabled);
    };

    render() {

        return (
            <div>
                <p>{this.props.user.username}</p>
                <p>{this.props.user.email}</p>

                <input type='checkbox' checked={this.props.user.enabled} onChange={this.handleCheck}/>
            </div>
        )
    }
}

export default UserForm
